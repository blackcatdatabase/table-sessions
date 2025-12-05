-- Auto-generated from schema-map-mysql.yaml (map@sha1:5E62933580349BE7C623D119AC9D1301A62F03EF)
-- engine: mysql
-- table:  sessions

ALTER TABLE sessions ADD CONSTRAINT fk_sessions_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;
