INSERT INTO users (username, email, password, name, description, photo, is_private)
VALUES
  ('John Doe', 'admin@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'Johnny', 'Travel.', 'johnny.jpg', false),
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
  ('michaelbrown@gmail.com', 'Michael Brown', '$2y$12$T3zMwcp0B5sfS71rce48yeRm8FGUt1k/NZc/fOKHX649cPUW8piQm', 2);


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
