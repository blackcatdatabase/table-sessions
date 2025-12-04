-- Auto-generated from schema-views-mysql.yaml (map@74ce4f4)
-- engine: mysql
-- table:  sessions

-- Contract view for [sessions]
-- Hides token_hash and session_blob; adds activity helper.
CREATE OR REPLACE ALGORITHM=MERGE SQL SECURITY INVOKER VIEW vw_sessions AS
SELECT
  id,
  token_hash_key_version,
  CAST(UPPER(SHA2(token_hash, 256)) AS CHAR(64)) AS token_hash_hex,
  token_fingerprint,
  CAST(LPAD(HEX(token_fingerprint), 64, '0') AS CHAR(64)) AS token_fingerprint_hex,
  token_issued_at,
  user_id,
  created_at,
  version,
  last_seen_at,
  expires_at,
  (revoked = 0 AND (expires_at IS NULL OR expires_at > NOW())) AS is_active,
  failed_decrypt_count,
  last_failed_decrypt_at,
  revoked,
  ip_hash,
  CAST(LPAD(HEX(ip_hash), 64, '0')  AS CHAR(64)) AS ip_hash_hex,
  ip_hash_key_version,
  user_agent,
  CAST(UPPER(SHA2(session_blob, 256)) AS CHAR(64)) AS session_blob_hex
FROM sessions;
