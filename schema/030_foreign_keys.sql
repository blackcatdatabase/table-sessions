-- Auto-generated from schema-map.psd1 on 2025-10-21T02:32:05
-- table: sessions
ALTER TABLE sessions ADD CONSTRAINT fk_sessions_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;
