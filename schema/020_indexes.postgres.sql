-- Auto-generated from schema-map-postgres.psd1 (map@9d3471b)
-- engine: postgres
-- table:  sessions
CREATE INDEX IF NOT EXISTS idx_sessions_user_created ON sessions (user_id, created_at);

CREATE INDEX IF NOT EXISTS idx_sessions_user ON sessions (user_id);

CREATE INDEX IF NOT EXISTS idx_sessions_expires_at ON sessions (expires_at);

CREATE INDEX IF NOT EXISTS idx_sessions_last_seen ON sessions (last_seen_at);

CREATE INDEX IF NOT EXISTS idx_sessions_token_hash_key ON sessions (token_hash_key_version);

CREATE INDEX IF NOT EXISTS idx_sessions_created_at ON sessions (created_at);
