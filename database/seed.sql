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
    id_blocked_by INTEGER REFERENCES admin(id) ON DELETE SET NULL,
    remember_token VARCHAR
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


INSERT INTO users (username, email, password, name, description, photo, is_private)
VALUES
  ('alice94', 'alice.johnson@gmail.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Alice Johnson', 'Travel enthusiast and photographer.', 'alice_profile.jpg', false),
  ('bob1987', 'bob.smith@yahoo.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Bob Smith', 'Music lover and guitar player.', 'bob_profile.jpg', false),
  ('carol2000', 'carol.adams@hotmail.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Carol Adams', 'Foodie and recipe collector.', 'carol_profile.jpg', false),
  ('dave85', 'dave.wilson@outlook.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Dave Wilson', 'Fitness guru and adventure seeker.', 'dave_profile.jpg', false),
  ('elena75', 'elena.martinez@aol.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Elena Martinez', 'Fashionista and makeup artist.', 'elena_profile.jpg', false),
  ('alexsmith3', 'alex.smith@hotmail.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Alex Smith', 'Student and artist.', 'alex_smith.jpg', false),
  ('emilyjones4', 'emily.jones@outlook.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Emily Jones', 'Cooking enthusiast and food lover.', 'emily_jones.jpg', false),
  ('chriswilson5', 'chris.wilson@aol.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Chris Wilson', 'Tech geek and gamer.', 'chris_wilson.jpg', false),
  ('sarahbrown6', 'sarah.brown@gmail.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Sarah Brown', 'Bookworm and book club organizer.', 'sarah_brown.jpg', false),
  ('michaellee7', 'michael.lee@yahoo.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Michael Lee', 'Fitness trainer and health enthusiast.', 'michael_lee.jpg', true),
  ('oliviajackson8', 'olivia.jackson@hotmail.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Olivia Jackson', 'Art and fashion lover.', 'olivia_jackson.jpg', false),
  ('andrewmoore9', 'andrew.moore@outlook.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Andrew Moore', 'Photography hobbyist and traveler.', 'andrew_moore.jpg', false),
  ('gracewilson10', 'grace.wilson@aol.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Grace Wilson', 'Nature explorer and wildlife enthusiast.', 'grace_wilson.jpg', true),
  ('williamdavis11', 'william.davis@gmail.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'William Davis', 'Musician and songwriter.', 'william_davis.jpg', false),
  ('ameliajames12', 'amelia.james@yahoo.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Amelia James', 'Coffee addict and coffee shop hopper.', 'amelia_james.jpg', false),
  ('danielthomas13', 'daniel.thomas@hotmail.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Daniel Thomas', 'Tech enthusiast and software developer.', 'daniel_thomas.jpg', false),
  ('miajohnson14', 'mia.johnson@outlook.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Mia Johnson', 'Yoga lover and instructor.', 'mia_johnson.jpg', false),
  ('ethanhall15', 'ethan.hall@aol.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Ethan Hall', 'Adventurer and thrill-seeker.', 'ethan_hall.jpg', true),
  ('lilyharris16', 'lily.harris@gmail.com', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 'Lily Harris', 'Fashion blogger and designer.', 'lily_harris.jpg', false);

INSERT INTO admin (email, name, password, id_created_by)
VALUES
  ('johnsmith@gmail.com', 'John Smith', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', NULL),
  ('emmawilliams@yahoo.com', 'Emma williams', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 1),
  ('marysmith@hotmail.com', 'Mary Smith', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 2),
  ('michaelbrown@gmail.com', 'Michael Brown', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 2),
  ('admin@example.com', 'Admin', '$2a$12$bZWMN0BRqYrLplO1N7UP2O7MH2s4b6sywbcb5LHbWqdr1gvLR4lfy', NULL);


INSERT INTO follows (id_user, id_followed, since) VALUES
  (1, 2, '2023-10-01'),
  (1, 3, '2023-10-02'),
  (1, 4, '2023-10-28'),
  (1, 5, '2023-10-29'),
  (1, 7, '2023-10-30'),
  (2, 1, '2023-10-03'),
  (2, 3, '2023-10-04'),
  (3, 1, '2023-10-05'),
  (3, 2, '2023-10-06'),
  (4, 5, '2023-10-07'),
  (4, 6, '2023-10-08'),
  (5, 4, '2023-10-09'),
  (5, 6, '2023-10-10'),
  (6, 4, '2023-10-11'),
  (6, 5, '2023-10-12'),
  (2, 4, '2023-10-31'),
  (2, 6, '2023-11-01'),
  (2, 9, '2023-11-02'),
  (2, 10, '2023-11-03'),
  (3, 5, '2023-11-04'),
  (3, 7, '2023-11-05'),
  (3, 8, '2023-11-06'),
  (3, 12, '2023-11-07'),
  (4, 10, '2023-11-08'),
  (4, 13, '2023-11-09'),
  (5, 12, '2023-11-10'),
  (5, 14, '2023-11-11'),
  (5, 15, '2023-11-12'),
  (6, 9, '2023-11-13'),
  (6, 11, '2023-11-14'),
  (6, 16, '2023-11-15'),
  (7, 1, '2023-11-16'),
  (8, 2, '2023-11-17'),
  (9, 3, '2023-11-18'),
  (10, 4, '2023-11-19'),
  (11, 5, '2023-11-20'),
  (12, 6, '2023-11-21'),
  (13, 1, '2023-11-22'),
  (14, 2, '2023-11-23'),
  (15, 3, '2023-11-24'),
  (16, 4, '2023-11-25'),
  (17, 5, '2023-11-26'),
  (18, 6, '2023-11-27'),
  (19, 1, '2023-11-28');

INSERT INTO theme (name)
VALUES
  ('sports'),
  ('tennis'),
  ('esports'),
  ('mathematics'),
  ('competitive programming'),
  ('leic'),
  ('feup'),
  ('leec'),
  ('chess'),
  ('video games'),
  ('cooking'),
  ('music'),
  ('photography'),
  ('travel'),
  ('science'),
  ('football'),
  ('basketball'),
  ('baseball'),
  ('soccer'),
  ('swimming'),
  ('cycling'),
  ('running'),
  ('golf'),
  ('cricket'),
  ('hockey');

-- Sample Group Data with Realistic Names and Creation Dates
INSERT INTO groups (name, description, id_owner)
VALUES
  ('Travel Explorers', 'A group for avid travelers.', 1),
  ('Music Enthusiasts', 'Join us to discuss your favorite music.', 2),
  ('Foodies United', 'For those who love cooking and trying new dishes.', 3),
  ('Outdoor Adventure Club', 'Explore the great outdoors with us.', 4),
  ('Fashion & Beauty Trends', 'Discuss the latest fashion and beauty trends.', 5),
  ('Tech Geeks Society', 'All things tech, gadgets, and gaming.', 6),
  ('Chess Lovers Club', 'Share your love for chess.', 7),
  ('Fitness Fanatics', 'Stay fit and healthy with like-minded individuals.', 8),
  ('Art & Fashion Enthusiasts', 'Explore art and fashion in-depth.', 9),
  ('Photography Enthusiasts', 'For those passionate about capturing moments.', 10),
  ('Nature Lovers', 'Connect with fellow nature enthusiasts.', 11),
  ('Music Makers Community', 'Musicians and songwriters unite.', 12),
  ('Coffee Lovers Corner', 'Discuss your love for coffee and cafes.', 13),
  ('Tech & Software Developers', 'Connect with fellow developers.', 14),
  ('Yoga & Wellness Group', 'Find inner peace and wellness.', 15),
  ('Adventure Seekers', 'Adventures, thrill-seekers, and adrenaline junkies.', 16),
  ('Fashion Bloggers Hub', 'Share your fashion blogging experiences.', 17),
  ('Sports Enthusiasts', 'For fans of various sports activities.', 18),
  ('Healthy Cooking Club', 'Healthy recipes and cooking tips.', 19);

INSERT INTO group_member (id_user, id_group)
VALUES
  (2, 1),
  (3, 1),
  (1, 2),
  (4, 2),
  (1, 3),
  (5, 3),
  (2, 4),
  (6, 4),
  (3, 5),
  (7, 5),
  (4, 6),
  (8, 6),
  (5, 7),
  (9, 7);


-- Adding Themes for Each Group
INSERT INTO group_theme (id_group, id_theme)
VALUES
  (1, 1),  -- Travel Explorers: sports
  (1, 14), -- Travel Explorers: travel
  (2, 12), -- Music Enthusiasts: music
  (3, 10), -- Foodies United: cooking
  (4, 14),  -- Outdoor Adventure Club: travel
  (4, 1), -- Outdoor Adventure Club: sports
  (5, 9),  -- Fashion & Beauty Trends: photography
  (6, 6),  -- Tech Geeks Society: leic
  (6, 5),  -- Tech Geeks Society: competitive programming
  (6, 8),  -- Tech Geeks Society: leec
  (7, 7),  -- Chess Lovers Club: chess
  (8, 14), -- Fitness Fanatics: science
  (8, 13), -- Fitness Fanatics: healthy cooking
  (8, 18); -- Fitness Fanatics: sports

-- Posts that belong to a group
INSERT INTO post (content, id_created_by, id_group, id_parent)
VALUES
  ('Just finished a 10-mile hike in the mountains. What an adventure!', 4, 4, NULL),  -- Outdoor Adventure Club: travel
  ('Does anyone want to go to a concert with me? It is a week from today', 2, 2, NULL),          -- Music Enthusiasts: music
  ('Trying out a new recipe today: Spicy Thai Curry. Yum!', 3, 3, NULL),           -- Foodies United: cooking
  ('Solving coding challenges in our competitive programming group. #CodingLife', 6, 6, NULL),  -- Tech Geeks Society: competitive programming
  ('Just started reading "The Queen''s Gambit." Anyone else reading it?', 7, 7, NULL);  -- Chess Lovers Club: chess

-- Sample Comment Data with Group Associations
INSERT INTO post (content, id_created_by, id_group, id_parent)
VALUES
  ('Sounds like an amazing adventure! I''d love to join you on a hike sometime.', 2, 4, 1),
  ('I''m a huge fan of concerts! Which band is playing at the concert?', 1, 2, 2),
  ('The Thai Curry sounds delicious! Can you share the recipe?', 5, 3, 3),
  ('Coding challenges are so much fun. Keep up the great work!', 8, 6, 4),
  ('I loved "The Queen''s Gambit." It''s a fantastic read!', 9, 7, 5);

-- Additional Posts Not Belonging to a Group
INSERT INTO post (content, id_created_by, id_group, id_parent)
VALUES
  ('A scenic morning run by the beach. Perfect way to start the day!', 8, NULL, NULL),
  ('Enjoying a quiet evening with a good book. Any book recommendations?', 7, NULL, NULL),
  ('Just had the best homemade pizza for dinner. Who else loves pizza?', 4, NULL, NULL),
  ('Spent the day hiking and exploring nature. Feeling refreshed!', 6, NULL, NULL),
  ('Finished a new painting today. Artistic expression is so fulfilling.', 9, NULL, NULL),
  ('Long bike ride through the city streets. It''s a beautiful evening!', 5, NULL, NULL),
  ('Watching the stars on a clear night. Nature''s wonders never cease to amaze.', 8, NULL, NULL),
  ('Working on a new coding project. Late nights are for creativity!', 11, NULL, NULL),
  ('Trying out a new recipe for a delicious dessert. Stay tuned for the result!', 10, NULL, NULL),
  ('Exploring the local farmers market. Fresh produce and vibrant colors!', 15, NULL, NULL),
  ('Morning yoga routine to start the day with peace and energy.', 14, NULL, NULL),
  ('Late night working on a project for LBAW today. @alexsmith3 @dave85', 16, NULL, NULL);

-- Sample Likes Data for Posts
INSERT INTO liked (id_user, id_post)
VALUES
  (1, 11),
  (2, 12),
  (3, 13),
  (4, 14),
  (5, 15),
  (6, 16),
  (7, 17),
  (8, 18),
  (9, 19),
  (10, 20),
  (11, 21);

INSERT INTO group_notification(type, id_user, id_group)
VALUES
  ('Request', 1, 7),
  ('Invitation', 3, 4),
  ('Request', 2, 3),
  ('Invitation', 1, 4),
  ('Invitation', 9, 1);

INSERT INTO follow_request (timestamp, id_user_to, id_user_from)
VALUES
  ('2023-12-01', 1, 8),
  ('2023-12-02', 2, 7),
  ('2023-12-03', 3, 15),
  ('2023-12-04', 4, 9),
  ('2023-12-05', 5, 10);
