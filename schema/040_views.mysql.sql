-- Auto-generated from schema-views-mysql.psd1 (map@38d5403)
-- engine: mysql
-- table:  sessions
-- Contract view for [sessions]
-- Hides token_hash and session_blob; adds activity helper.
CREATE OR REPLACE SQL SECURITY INVOKER VIEW vw_sessions AS
SELECT
  id,
  token_hash_key_version,
  token_fingerprint,
  HEX(token_fingerprint) AS token_fingerprint_hex,
  token_issued_at,
  user_id,
  created_at,
  last_seen_at,
  expires_at,
  (revoked = 0 AND (expires_at IS NULL OR expires_at > NOW())) AS is_active,
  failed_decrypt_count,
  last_failed_decrypt_at,
  revoked,
  ip_hash,
  HEX(ip_hash) AS ip_hash_hex,
  ip_hash_key_version,
  user_agent
FROM sessions;
