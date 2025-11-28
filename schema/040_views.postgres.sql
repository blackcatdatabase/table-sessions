-- Auto-generated from schema-views-postgres.psd1 (map@mtime:2025-11-27T15:36:13Z)
-- engine: postgres
-- table:  sessions

-- Contract view for [sessions]
-- Hides token_hash and session_blob; adds activity helper & hex helpers.
CREATE OR REPLACE VIEW vw_sessions AS
SELECT
  id,
  token_hash_key_version,
  UPPER(encode(digest(token_hash,'sha256'),'hex')) AS token_hash_hex,
  token_fingerprint,
  UPPER(encode(token_fingerprint,'hex')) AS token_fingerprint_hex,
  token_issued_at,
  user_id,
  created_at,
  version,
  last_seen_at,
  expires_at,
  (NOT revoked AND (expires_at IS NULL OR expires_at > now())) AS is_active,
  failed_decrypt_count,
  last_failed_decrypt_at,
  revoked,
  ip_hash,
  UPPER(encode(ip_hash,'hex')) AS ip_hash_hex,
  ip_hash_key_version,
  user_agent,
  UPPER(encode(digest(session_blob,'sha256'),'hex')) AS session_blob_hex
FROM sessions;
