-- Inserting data into admin table
INSERT INTO admin (email, name, password)
VALUES ('admin@admin.com', 'Admin', '$2y$12$wWRGq5d9H5kKtGub58p0n.9wUWokcO8tTIRb9n43cmSzqDhMptVai');

-- Inserting data into user table
INSERT INTO "user" (username, email, password, is_private, is_active, id_profile)
VALUES ('test_user', 'user@user.com', '$2y$12$DBcLz2el8.AQD3K8H31o..gbE9A4PdYwDYyRFkBEbgDPCD3M2NsZK', true, true, 1);
VALUES ('user1', 'user1@example.com', '$2y$12$1NO7QX8vdo/gYFpy4A9Y2unF6V2SAnAeawz5fVtOZpt9VvJl46nHC', true, true, 2);
VALUES ('user2', 'user2@example.com', '$2y$12$r8Sc.xj3kQn0e8Kv4dtkqu3bxPvEgdmm68pwI1Yv5So0I8GTwS7E6', true, true, 3);
VALUES ('user3', 'user3@example.com', '$2y$12$UYpdp9t/wGzzg/tcGUb6mu4V0/gTdMIzEgfiV3QI5em3YWsM/nI2K', true, true, 4);

-- Profiles
INSERT INTO profile (name, description) 
VALUES 
    ('Profile3', 'Description for Profile3'),
    ('Profile4', 'Description for Profile4'),
    ('Profile5', 'Description for Profile5'),
    ('Profile6', 'Description for Profile6'),
    ('Profile7', 'Description for Profile7'),
    ('Profile8', 'Description for Profile8'),
    ('Profile9', 'Description for Profile9'),
    ('Profile10', 'Description for Profile10'),
    ('Profile11', 'Description for Profile11'),
    ('Profile12', 'Description for Profile12');

-- Follows
INSERT INTO follows (id_user, id_followed, since) 
VALUES 
    (3, 4, '2023-10-22'),
    (4, 5, '2023-10-22'),
    (5, 6, '2023-10-22'),
    (6, 7, '2023-10-22'),
    (7, 8, '2023-10-22'),
    (8, 9, '2023-10-22'),
    (9, 10, '2023-10-22'),
    (10, 3, '2023-10-22'),
    (2, 5, '2023-10-22'),
    (1, 4, '2023-10-22');

-- Groups
INSERT INTO "group" (created_at, id_owner, id_profile) 
VALUES 
    ('2023-10-22', 2, 2),
    ('2023-10-22', 3, 3),
    ('2023-10-22', 4, 4),
    ('2023-10-22', 5, 5),
    ('2023-10-22', 6, 6),
    ('2023-10-22', 7, 7),
    ('2023-10-22', 8, 8),
    ('2023-10-22', 9, 9),
    ('2023-10-22', 10, 10),
    ('2023-10-22', 1, 1);

-- Group Members
INSERT INTO group_member (id_user, id_group) 
VALUES 
    (2, 1),
    (3, 2),
    (4, 3),
    (5, 4),
    (6, 5),
    (7, 6),
    (8, 7),
    (9, 8),
    (10, 9),
    (1, 10);

-- Themes
INSERT INTO theme (name) 
VALUES 
    ('Theme3'),
    ('Theme4'),
    ('Theme5'),
    ('Theme6'),
    ('Theme7'),
    ('Theme8'),
    ('Theme9'),
    ('Theme10'),
    ('Theme11'),
    ('Theme12');

-- Group Themes
INSERT INTO group_theme (id_group, id_theme) 
VALUES 
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 4),
    (5, 5),
    (6, 6),
    (7, 7),
    (8, 8),
    (9, 9),
    (10, 10);

-- Posts
INSERT INTO post (content, created_at, is_private, id_created_by, id_group, id_parent) 
VALUES 
    ('Content3', '2023-10-22', true, 3, 1, NULL),
    ('Content4', '2023-10-22', false, 4, 2, 1),
    ('Content5', '2023-10-22', true, 5, 3, 2),
    ('Content6', '2023-10-22', false, 6, 4, 3),
    ('Content7', '2023-10-22', true, 7, 5, 4),
    ('Content8', '2023-10-22', false, 8, 6, 5),
    ('Content9', '2023-10-22', true, 9, 7, 6),
    ('Content10', '2023-10-22', false, 10, 8, 7),
    ('Content11', '2023-10-22', true, 1, 9, 8),
    ('Content12', '2023-10-22', false, 2, 10, 9);

-- Liked
INSERT INTO liked (user_id, post_id) 
VALUES 
    (3, 2),
    (4, 1),
    (5, 4),
    (6, 3),
    (7, 6),
    (8, 5),
    (9, 8),
    (10, 7),
    (1, 10),
    (2, 9);

-- Follow Request
INSERT INTO follow_request (timestamp, id_user_to, id_user_from) 
VALUES 
    ('2023-10-22', 3, 1),
    ('2023-10-22', 4, 2),
    ('2023-10-22', 5, 3),
    ('2023-10-22', 6, 4),
    ('2023-10-22', 7, 5),
    ('2023-10-22', 8, 6),
    ('2023-10-22', 9, 7),
    ('2023-10-22', 10, 8),
    ('2023-10-22', 1, 9),
    ('2023-10-22', 2, 10);

-- Like Notification
INSERT INTO like_notification (timestamp, id_post, id_user) 
VALUES 
    ('2023-10-22', 2, 1),
    ('2023-10-22', 4, 2),
    ('2023-10-22', 6, 3),
    ('2023-10-22', 8, 4),
    ('2023-10-22', 10, 5),
    ('2023-10-22', 1, 6),
    ('2023-10-22', 3, 7),
    ('2023-10-22', 5, 8),
    ('2023-10-22', 7, 9),
    ('2023-10-22', 9, 10);

-- Comment Notification
INSERT INTO comment_notification (timestamp, id_comment) 
VALUES 
    ('2023-10-22', 1),
    ('2023-10-22', 2),
    ('2023-10-22', 3),
    ('2023-10-22', 4),
    ('2023-10-22', 5),
    ('2023-10-22', 6),
    ('2023-10-22', 7),
    ('2023-10-22', 8),
    ('2023-10-22', 9),
    ('2023-10-22', 10);

-- Group Notification
INSERT INTO group_notification (timestamp, type, id_user, id_group) 
VALUES 
    ('2023-10-22', 'Type2', 2, 1),
    ('2023-10-22', 'Type3', 3, 2),
    ('2023-10-22', 'Type4', 4, 3),
    ('2023-10-22', 'Type5', 5, 4),
    ('2023-10-22', 'Type6', 6, 5),
    ('2023-10-22', 'Type7', 7, 6),
    ('2023-10-22', 'Type8', 8, 7),
    ('2023-10-22', 'Type9', 9, 8),
    ('2023-10-22', 'Type10', 10, 9),
    ('2023-10-22', 'Type11', 1, 10);

-- Tag Notification
INSERT INTO tag_notification (timestamp, id_user, id_post) 
VALUES 
    ('2023-10-22', 1, 2),
    ('2023-10-22', 2, 3),
    ('2023-10-22', 3, 4),
    ('2023-10-22', 4, 5),
    ('2023-10-22', 5, 6),
    ('2023-10-22', 6, 7),
    ('2023-10-22', 7, 8),
    ('2023-10-22', 8, 9),
    ('2023-10-22', 9, 10),
    ('2023-10-22', 10, 1);

