CREATE INDEX user_username_search_idx ON "user" USING GIN (to_tsvector('english', username));
CREATE INDEX profile_name_search_idx ON profile USING GIN (to_tsvector('english', name));
CREATE INDEX post_content_search_idx ON post USING GIN (to_tsvector('english', content));
