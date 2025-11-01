-- Auto-generated from schema-views-postgres.psd1 (map@c5e4097)
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
  version,
  last_seen_at,
  expires_at,
  CASE WHEN (NOT revoked AND (expires_at IS NULL OR expires_at > now())) THEN 1 ELSE 0 END AS is_active,
  failed_decrypt_count,
  last_failed_decrypt_at,
  revoked,
  ip_hash,
  encode(ip_hash, 'hex') AS ip_hash_hex,
  ip_hash_key_version,
  user_agent,
  encode(token_hash,  'hex') AS token_hash_hex,
  encode(session_blob,'hex') AS session_blob_hex
FROM sessions;
