-- Auto-generated from schema-views-postgres.psd1 (map@38d5403)
-- engine: postgres
-- table:  sessions
-- Contract view for [sessions]
-- Hides token_hash and session_blob; adds activity helper & hex helpers.
CREATE OR REPLACE VIEW vw_sessions AS
SELECT
  id,
  token_hash_key_version,
  token_fingerprint,
  encode(token_fingerprint, 'hex') AS token_fingerprint_hex,
  token_issued_at,
  user_id,
  created_at,
  last_seen_at,
  expires_at,
  (NOT revoked AND (expires_at IS NULL OR expires_at > now())) AS is_active,
  failed_decrypt_count,
  last_failed_decrypt_at,
  revoked,
  ip_hash,
  encode(ip_hash, 'hex') AS ip_hash_hex,
  ip_hash_key_version,
  user_agent
FROM sessions;
