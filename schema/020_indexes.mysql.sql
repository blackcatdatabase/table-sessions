-- Auto-generated from schema-map-mysql.psd1 (map@mtime:2025-11-27T15:13:14Z)
-- engine: mysql
-- table:  sessions

CREATE INDEX idx_sessions_created_at ON sessions (created_at);
