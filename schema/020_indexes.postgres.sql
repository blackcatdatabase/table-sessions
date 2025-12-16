-- Auto-generated from schema-map-postgres.yaml (map@sha1:FAEA49A5D5F8FAAD9F850D0F430ED451C5C1D707)
-- engine: postgres
-- table:  sessions

CREATE INDEX IF NOT EXISTS idx_sessions_user_created ON sessions (user_id, created_at);

CREATE INDEX IF NOT EXISTS idx_sessions_user ON sessions (user_id);

CREATE INDEX IF NOT EXISTS idx_sessions_expires_at ON sessions (expires_at);

CREATE INDEX IF NOT EXISTS idx_sessions_last_seen ON sessions (last_seen_at);

CREATE INDEX IF NOT EXISTS idx_sessions_token_hash_key ON sessions (token_hash_key_version);

CREATE INDEX IF NOT EXISTS idx_sessions_created_at ON sessions (created_at);

CREATE INDEX IF NOT EXISTS idx_sessions_active ON sessions (revoked, expires_at, user_id);

CREATE INDEX IF NOT EXISTS idx_sessions_user_revoked_seen ON sessions (user_id, revoked, last_seen_at DESC);
