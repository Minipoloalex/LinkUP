CREATE TABLE admin (
    id SERIAL PRIMARY KEY,
    email VARCHAR UNIQUE NOT NULL,
    name VARCHAR,
    password VARCHAR NOT NULL,
    id_created_by INTEGER REFERENCES admin(id)
);

CREATE TABLE profile (
    id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL,
    description TEXT,
    photo BYTEA
);

CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR UNIQUE,
    email VARCHAR UNIQUE,
    password VARCHAR,
    is_private BOOLEAN DEFAULT true NOT NULL,
    is_active BOOLEAN DEFAULT true NOT NULL,
    id_blocked_by INTEGER REFERENCES admin(id),
    id_profile INTEGER REFERENCES profile(id) NOT NULL
);

CREATE TABLE follows (
    id SERIAL PRIMARY KEY,
    id_user INTEGER REFERENCES "user"(id),
    id_followed INTEGER REFERENCES "user"(id),
    since DATE DEFAULT CURRENT_DATE NOT NULL
);

CREATE TABLE "group" (
    id SERIAL PRIMARY KEY,
    created_at DATE DEFAULT CURRENT_DATE NOT NULL,
    id_owner INTEGER REFERENCES "user"(id) NOT NULL,
    id_profile INTEGER REFERENCES profile(id) UNIQUE NOT NULL
);

CREATE TABLE group_member (
    id SERIAL PRIMARY KEY,
    id_user INTEGER REFERENCES "user"(id),
    id_group INTEGER REFERENCES "group"(id)
);

CREATE TABLE theme (
    id SERIAL PRIMARY KEY,
    name VARCHAR UNIQUE NOT NULL
);

CREATE TABLE group_theme (
    id_group INTEGER REFERENCES "group"(id),
    id_theme INTEGER REFERENCES theme(id),
    PRIMARY KEY (id_group, id_theme)
);

CREATE TABLE post (
    id SERIAL PRIMARY KEY,
    content TEXT,
    created_at DATE DEFAULT CURRENT_DATE NOT NULL,
    is_private BOOLEAN DEFAULT true NOT NULL,
    media BYTEA,
    id_created_by INTEGER REFERENCES "user"(id) NOT NULL,
    id_group INTEGER REFERENCES "group"(id),
    id_parent INTEGER REFERENCES post(id)
);

CREATE TABLE liked (
    user_id INTEGER REFERENCES "user"(id),
    post_id INTEGER REFERENCES post(id),
    PRIMARY KEY (user_id, post_id)
);

CREATE TABLE follow_request (
    id SERIAL PRIMARY KEY,
    timestamp DATE DEFAULT CURRENT_DATE NOT NULL,
    id_user_to INTEGER REFERENCES "user"(id) NOT NULL,
    id_user_from INTEGER REFERENCES "user"(id) NOT NULL
);

CREATE TABLE like_notification (
    id SERIAL PRIMARY KEY,
    timestamp DATE DEFAULT CURRENT_DATE NOT NULL,
    id_post INTEGER REFERENCES post(id) NOT NULL,
    id_user INTEGER REFERENCES "user"(id) NOT NULL
);

CREATE TABLE comment_notification (
    id SERIAL PRIMARY KEY,
    timestamp DATE DEFAULT CURRENT_DATE NOT NULL,
    id_comment INTEGER REFERENCES post(id) UNIQUE NOT NULL
);

CREATE TABLE group_notification (
    id SERIAL PRIMARY KEY,
    timestamp DATE DEFAULT CURRENT_DATE NOT NULL,
    type VARCHAR CHECK (type IN ('Types')),
    id_user INTEGER REFERENCES "user"(id) NOT NULL,
    id_group INTEGER REFERENCES "group"(id) NOT NULL
);

CREATE TABLE tag_notification (
    id SERIAL PRIMARY KEY,
    timestamp DATE DEFAULT CURRENT_DATE NOT NULL,
    id_user INTEGER REFERENCES "user"(id) NOT NULL,
    id_post INTEGER REFERENCES post(id) NOT NULL
);

