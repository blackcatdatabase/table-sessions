-- Auto-generated from schema-views-postgres.psd1 (map@mtime:2025-10-24T09:45:40Z)
-- engine: postgres
-- table:  sessions
-- Contract view for [sessions]
-- Hides token_hash and session_blob.
CREATE OR REPLACE VIEW vw_sessions AS
SELECT
  id,
  token_hash_key_version,
  token_fingerprint,
  token_issued_at,
  user_id,
  created_at,
  last_seen_at,
  expires_at,
  failed_decrypt_count,
  last_failed_decrypt_at,
  revoked,
  ip_hash,
  ip_hash_key_version,
  user_agent
FROM sessions;
