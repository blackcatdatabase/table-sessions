-- Auto-generated from schema-map-mysql.yaml (map@74ce4f4)
-- engine: mysql
-- table:  sessions

CREATE INDEX idx_sessions_created_at ON sessions (created_at);
