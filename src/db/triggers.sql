-- Trigger for follow events
CREATE OR REPLACE FUNCTION follow_trigger_function() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO follow_notification (timestamp, id_user, id_followed) 
    VALUES (CURRENT_DATE, NEW.id_user, NEW.id_followed);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER follow_trigger
AFTER INSERT ON follows
FOR EACH ROW
EXECUTE FUNCTION follow_trigger_function();

-- Trigger for like events
CREATE OR REPLACE FUNCTION like_trigger_function() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO like_notification (timestamp, id_post, id_user) 
    VALUES (CURRENT_DATE, NEW.post_id, NEW.user_id);
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
EXECUTE FUNCTION comment_trigger_function();

-- Trigger for group events
CREATE OR REPLACE FUNCTION group_trigger_function() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO group_notification (timestamp, type, id_user, id_group) 
    VALUES (CURRENT_DATE, 'Group Event', NEW.id_user, NEW.id_group);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER group_trigger
AFTER INSERT ON "group"
FOR EACH ROW
EXECUTE FUNCTION group_trigger_function();

-- Trigger for tag events
CREATE OR REPLACE FUNCTION tag_trigger_function() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO tag_notification (timestamp, id_user, id_post) 
    VALUES (CURRENT_DATE, NEW.id_user, NEW.id_post);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER tag_trigger
AFTER INSERT ON post
FOR EACH ROW
EXECUTE FUNCTION tag_trigger_function();

-- CREATE PROFILE
CREATE OR REPLACE FUNCTION create_profile_for_new_user() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO profile (id, name, description, photo)
    VALUES (NEW.id, NEW.username, NULL, 'default.jpg');
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

