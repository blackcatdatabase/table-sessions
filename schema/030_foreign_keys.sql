-- Auto-generated from schema-map.psd1 (map@6cefe8e)
-- table: sessions
ALTER TABLE sessions ADD CONSTRAINT fk_sessions_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;
