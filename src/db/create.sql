-- Use this code to drop and create a schema.
--
DROP SCHEMA IF EXISTS lbaw232451 CASCADE;
CREATE SCHEMA lbaw232451;
SET search_path TO lbaw232451;

-- Drop tables: do not need to drop if the schema is dropped (see above)
-- DROP TABLE IF EXISTS liked;
-- DROP TABLE IF EXISTS tag_notification;
-- DROP TABLE IF EXISTS like_notification;
-- DROP TABLE IF EXISTS comment_notification;
-- DROP TABLE IF EXISTS follow_request;
-- DROP TABLE IF EXISTS group_notification;
-- DROP TABLE IF EXISTS group_theme;
-- DROP TABLE IF EXISTS theme;
-- DROP TABLE IF EXISTS group_member;
-- DROP TABLE IF EXISTS post;
-- DROP TABLE IF EXISTS follows;
-- DROP TABLE IF EXISTS groups;
-- DROP TABLE IF EXISTS users;
-- DROP TABLE IF EXISTS admin;

-- DROP TYPE IF EXISTS group_notification_type;
CREATE TYPE group_notification_type AS ENUM('Request', 'Invitation');

CREATE TABLE admin (
    id SERIAL PRIMARY KEY,
    email VARCHAR(200) UNIQUE NOT NULL,
    name VARCHAR(200),
    password TEXT NOT NULL,
    id_created_by INTEGER REFERENCES admin(id) ON DELETE SET NULL
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(200) UNIQUE,
    email VARCHAR(200) UNIQUE,
    password TEXT,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    photo TEXT DEFAULT 'def.jpg',
    is_private BOOLEAN DEFAULT true NOT NULL,
    id_blocked_by INTEGER REFERENCES admin(id) ON DELETE SET NULL
);
CREATE TABLE follows (
    id_user INTEGER REFERENCES users(id),
    id_followed INTEGER REFERENCES users(id),
    since DATE DEFAULT CURRENT_DATE NOT NULL,
    PRIMARY KEY (id_user, id_followed)
);
CREATE TABLE groups (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    photo TEXT DEFAULT 'def.jpg',
    created_at DATE DEFAULT CURRENT_DATE NOT NULL,
    id_owner INTEGER REFERENCES users(id) ON DELETE SET NULL NOT NULL
);

CREATE TABLE group_member (
    id_user INTEGER REFERENCES users(id) ON DELETE CASCADE,
    id_group INTEGER REFERENCES groups(id) ON DELETE CASCADE,
    PRIMARY KEY (id_user, id_group)
);
CREATE TABLE theme (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE group_theme (
    id_group INTEGER REFERENCES groups(id) ON DELETE CASCADE,
    id_theme INTEGER REFERENCES theme(id) ON DELETE CASCADE,
    PRIMARY KEY (id_group, id_theme)
);

CREATE TABLE post (
    id SERIAL PRIMARY KEY,
    content TEXT,
    created_at DATE DEFAULT CURRENT_DATE NOT NULL,
    is_private BOOLEAN DEFAULT true NOT NULL,
    media TEXT,
    id_created_by INTEGER REFERENCES users(id) ON DELETE SET NULL NOT NULL,
    id_group INTEGER REFERENCES groups(id) ON DELETE CASCADE,
    id_parent INTEGER REFERENCES post(id) ON DELETE SET NULL
);
CREATE TABLE liked (
    id_user INTEGER REFERENCES users(id) ON DELETE CASCADE,
    id_post INTEGER REFERENCES post(id) ON DELETE CASCADE,
    PRIMARY KEY (id_user, id_post)
);

CREATE TABLE follow_request (
    id SERIAL PRIMARY KEY,
    timestamp DATE DEFAULT CURRENT_DATE NOT NULL,
    id_user_to INTEGER REFERENCES users(id) ON DELETE CASCADE NOT NULL,
    id_user_from INTEGER REFERENCES users(id) ON DELETE CASCADE NOT NULL,
    UNIQUE (id_user_to, id_user_from)
);

CREATE TABLE like_notification (
    id SERIAL PRIMARY KEY,
    timestamp DATE DEFAULT CURRENT_DATE NOT NULL,
    id_post INTEGER REFERENCES post(id) ON DELETE CASCADE NOT NULL,
    id_user INTEGER REFERENCES users(id) ON DELETE CASCADE NOT NULL,
    UNIQUE (id_post, id_user)
);

CREATE TABLE comment_notification (
    id SERIAL PRIMARY KEY,
    timestamp DATE DEFAULT CURRENT_DATE NOT NULL,
    id_comment INTEGER REFERENCES post(id) ON DELETE CASCADE UNIQUE NOT NULL
);

CREATE TABLE group_notification (
    id SERIAL PRIMARY KEY,
    timestamp DATE DEFAULT CURRENT_DATE NOT NULL,
    type group_notification_type NOT NULL,
    id_user INTEGER REFERENCES users(id) ON DELETE CASCADE NOT NULL,
    id_group INTEGER REFERENCES groups(id) ON DELETE CASCADE NOT NULL,
    UNIQUE (id_user, id_group, type)
);

CREATE TABLE tag_notification (
    id SERIAL PRIMARY KEY,
    timestamp DATE DEFAULT CURRENT_DATE NOT NULL,
    id_user INTEGER REFERENCES users(id) ON DELETE CASCADE NOT NULL,
    id_post INTEGER REFERENCES post(id) ON DELETE CASCADE NOT NULL,
    UNIQUE (id_user, id_post)
);

------------------------------------------------
------------- Performance indices --------------
------------------------------------------------

CREATE INDEX post_created_at_btree_index
ON post USING BTREE(created_at);

CREATE INDEX group_member_id_user_index
ON group_member USING HASH(id_user);
-- e.g. SELECT id_group FROM group_member where id_user = 1;

------------------------------------------------
---------- Full text search indices ------------
------------------------------------------------

------------------------------------------------
-- GIN index for users table
------------------------------------------------

-- Add column to users to store the computed ts_vectors 
ALTER TABLE users
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to update ts_vectors automatically. It will be used for a trigger
CREATE OR REPLACE FUNCTION user_search_update() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
    NEW.tsvectors = (
        setweight(to_tsvector('english', NEW.username), 'A') ||
        setweight(to_tsvector('english', NEW.name), 'B') ||
        setweight(to_tsvector('english', NEW.description), 'C')
    );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.username <> OLD.username OR NEW.name <> OLD.name OR NEW.description <> OLD.description) THEN
            NEW.tsvectors = (
                setweight(to_tsvector('english', NEW.username), 'A') ||
                setweight(to_tsvector('english', NEW.name), 'B') ||
                setweight(to_tsvector('english', NEW.description), 'C')
            );
        END IF;
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger before insert or update on work.
CREATE TRIGGER user_search_update
BEFORE INSERT OR UPDATE ON users
FOR EACH ROW
EXECUTE PROCEDURE user_search_update();


-- Finally, create a GIN index in table users for ts_vectors.
CREATE INDEX user_search_idx ON users USING GIN (tsvectors);
------------------------------------------------

------------------------------------------------
-- GIN index for groups table
------------------------------------------------

-- Add groups to users to store the computed ts_vectors 
ALTER TABLE groups
ADD COLUMN tsvectors TSVECTOR;

-- Function to generate the tsvector based on the group name and the theme names
CREATE OR REPLACE FUNCTION generate_group_tsvector(group_name VARCHAR, theme_names VARCHAR[])
RETURNS TSVECTOR AS $$
BEGIN
    -- Convert the group name into a tsvector with weight 'A'
    -- Concatenate the theme names with weight 'B'
    RETURN setweight(to_tsvector('english', group_name), 'A') ||
           setweight(to_tsvector('english', array_to_string(theme_names, ' ')), 'B');
END $$
LANGUAGE plpgsql;
CREATE OR REPLACE FUNCTION group_search_update()
RETURNS TRIGGER AS $$
BEGIN
    -- Update the 'tsvectors' column with the weighted tsvector
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = generate_group_tsvector(NEW.name,
            ARRAY(SELECT t.name
                FROM theme t JOIN group_theme gt ON t.id = gt.id_theme
                WHERE gt.id_group = NEW.id
            )
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.name <> OLD.name) THEN
            NEW.tsvectors = generate_group_tsvector(NEW.name,
                ARRAY(SELECT t.name
                    FROM theme t JOIN group_theme gt ON t.id = gt.id_theme
                    WHERE gt.id_group = NEW.id
                )
            );
        END IF;
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger on the groups table to update the tsvectors (before insert or update)
CREATE TRIGGER group_search_trigger
BEFORE INSERT OR UPDATE ON groups
FOR EACH ROW
EXECUTE FUNCTION group_search_update();

-- Function to update the tsvector in the groups table when a theme is added or removed from a group
CREATE OR REPLACE FUNCTION update_theme_group_tsvector()
RETURNS TRIGGER AS $$
BEGIN
    -- Update the tsvectors column in the groups table
    IF TG_OP = 'INSERT' THEN
        UPDATE groups g
        SET tsvectors = generate_group_tsvector(g.name, ARRAY(
            SELECT t.name
            FROM theme t JOIN group_theme gt ON t.id = gt.id_theme
            WHERE gt.id_group = NEW.id_group)
        )
        WHERE g.id = NEW.id_group;
    END IF;
    IF TG_OP = 'DELETE' THEN
        UPDATE groups g
        SET tsvectors = generate_group_tsvector(g.name, ARRAY(
            SELECT t.name
            FROM theme t JOIN group_theme gt ON t.id = gt.id_theme
            WHERE gt.id_group = OLD.id_group)
        )
        WHERE g.id = OLD.id_group;
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger that fires after an INSERT or DELETE in the group_theme table to update the tsvector in the group table
CREATE TRIGGER group_theme_tsvector_trigger
AFTER INSERT OR DELETE ON group_theme
FOR EACH ROW
EXECUTE FUNCTION update_theme_group_tsvector();

-- Finally, create a GIN index in table groups for ts_vectors.
CREATE INDEX group_search_idx ON groups USING GIN (tsvectors);
------------------------------------------------


------------------------------------------------
-- GIST index for posts table (dynamic data)
------------------------------------------------
-- Searching posts: full text search on the content and the post's author


-- Add column to users to store the computed ts_vectors 
ALTER TABLE post
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to update ts_vectors automatically. It will be used for a trigger.
CREATE OR REPLACE FUNCTION post_search_update()
RETURNS TRIGGER AS $$
DECLARE
    _username TEXT;
    _name TEXT;
BEGIN
    IF TG_OP = 'INSERT' THEN
        SELECT username, name INTO _username, _name FROM users WHERE id = NEW.id_created_by;
        NEW.tsvectors = (
            setweight(to_tsvector('english', NEW.content), 'A') ||
            setweight(to_tsvector('english', _username), 'B') ||
            setweight(to_tsvector('english', _name), 'C')
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.content <> OLD.content) THEN    -- updates on post are never to the id_created_by attribute
            SELECT username, name INTO _username, _name FROM users WHERE id = NEW.id_created_by;
            NEW.tsvectors = (
            setweight(to_tsvector('english', NEW.content), 'A') ||
            setweight(to_tsvector('english', _username), 'B') ||
            setweight(to_tsvector('english', _name), 'C')
        );
        END IF;
    END IF;
    RETURN NEW;
END $$
LANGUAGE 'plpgsql';

-- Update the tsvector in the posts table when the user changes his name/username
CREATE OR REPLACE FUNCTION update_post_tsvectors_on_user_change()
RETURNS TRIGGER AS $$
BEGIN
    -- Update the "post" table when a user's name or username changes
    UPDATE post
    SET tsvectors = (
        setweight(to_tsvector('english', post.content), 'A') ||
        setweight(to_tsvector('english', NEW.name), 'B') ||
        setweight(to_tsvector('english', NEW.username), 'C')
    )
    WHERE id_created_by = NEW.id;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_post_tsvectors_trigger
AFTER UPDATE ON users
FOR EACH ROW
WHEN (OLD.name <> NEW.name OR OLD.username <> NEW.username)
EXECUTE FUNCTION update_post_tsvectors_on_user_change();


CREATE TRIGGER posts_search_trigger
BEFORE INSERT OR UPDATE ON post
FOR EACH ROW
EXECUTE FUNCTION post_search_update();

-- Finally, create a GIST index for ts_vectors (posts are dynamic data, many insertions).
CREATE INDEX post_search_idx ON post USING GIST (tsvectors);
------------------------------------------------


------------------------------------------------
------------------ Triggers --------------------
------------------------------------------------

-- Trigger for like events (user likes a post)
CREATE OR REPLACE FUNCTION like_trigger_function() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO like_notification (timestamp, id_post, id_user) 
    VALUES (CURRENT_DATE, NEW.id_post, NEW.id_user);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER like_trigger
AFTER INSERT ON liked
FOR EACH ROW
EXECUTE FUNCTION like_trigger_function();

-- Trigger for comment events
CREATE OR REPLACE FUNCTION comment_trigger_function() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO comment_notification (timestamp, id_comment) 
    VALUES (CURRENT_DATE, NEW.id);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER comment_trigger
AFTER INSERT ON post
FOR EACH ROW
WHEN (NEW.id_parent IS NOT NULL)
EXECUTE FUNCTION comment_trigger_function();

-- Trigger for tag events
CREATE OR REPLACE FUNCTION tag_trigger_function() RETURNS TRIGGER AS $$
DECLARE
    mention_pattern TEXT := '@(\w+)'; -- Regular expression to match usernames (e.g., "@cooluser123")
    mentions TEXT[];
    mentioned_user_id INTEGER;
    mentioned_user TEXT;
BEGIN
    -- Extract mentions from the content using regular expressions
    SELECT ARRAY(SELECT regexp_matches(NEW.content, mention_pattern, 'g')) INTO mentions;

    -- Loop through the mentions and insert notifications for each mentioned user
    FOREACH mentioned_user IN ARRAY mentions
    LOOP
        -- Remove the "@" symbol from the username
        -- mentioned_user = substring(mentioned_user from 2);
        -- Find the user ID based on the mentioned username
        SELECT id INTO mentioned_user_id
        FROM users
        WHERE username = mentioned_user
        AND (is_private = false OR
                (EXISTS (SELECT 1 FROM follows  -- user that created the post follows the mentioned user (private account)
                        WHERE NEW.id_created_by = id_user AND id = id_followed
                    )
                )
            );

        -- Insert a tag notification for the mentioned user
        IF mentioned_user_id IS NOT NULL THEN
            INSERT INTO tag_notification (timestamp, id_user, id_post)
            VALUES (CURRENT_DATE, mentioned_user_id, NEW.id);
        END IF;
    END LOOP;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER tag_trigger
AFTER INSERT ON post
FOR EACH ROW
EXECUTE FUNCTION tag_trigger_function();

-- BR05 Group Privacy: ensure users that do not belong to group cannot post on it
CREATE OR REPLACE FUNCTION check_user_can_insert_post_on_group()
RETURNS TRIGGER AS $$
BEGIN
    IF (NEW.id_group IS NULL) THEN
        RETURN NEW;
    ELSIF (
        NEW.id_created_by = (SELECT g.id_owner FROM groups g WHERE g.id = NEW.id_group) -- User is the owner
        OR EXISTS (SELECT 1 FROM group_member WHERE id_user = NEW.id_created_by AND id_group = NEW.id_group)  -- User is a member
    ) THEN
        RETURN NEW;
    ELSE
        RAISE EXCEPTION 'User does not have permission to insert a post in this group';
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER check_user_can_insert_post_on_group_trigger
BEFORE INSERT ON post
FOR EACH ROW
EXECUTE FUNCTION check_user_can_insert_post_on_group();

/*
Testing FTS indices
SELECT *
FROM post
WHERE tsvectors @@ to_tsquery('english', 'morning');
ORDER BY ts_rank(tsvectors, to_tsquery('english', 'morning')) DESC;


SELECT *
FROM groups
WHERE tsvectors @@ plainto_tsquery('english', 'music')
ORDER BY ts_rank(tsvectors, plainto_tsquery('english', 'music')) DESC;


SELECT *
FROM users
WHERE tsvectors @@ plainto_tsquery('english', 'dave adventure')
ORDER BY ts_rank(tsvectors, plainto_tsquery('english', 'dave adventure')) DESC;
*/
