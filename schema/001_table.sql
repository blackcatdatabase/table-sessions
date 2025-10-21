-- Auto-generated from schema-map.psd1 @ 1e83bb6 (2025-10-21T10:18:36+02:00)
-- table: sessions
CREATE TABLE IF NOT EXISTS sessions (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  token_hash BINARY(32) NOT NULL,
  token_hash_key_version VARCHAR(64) NULL,
  token_fingerprint BINARY(32) NULL,
  token_issued_at DATETIME(6) NULL,
  user_id BIGINT UNSIGNED NULL,
  created_at DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  last_seen_at DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  expires_at DATETIME(6) NULL,
  failed_decrypt_count INT UNSIGNED NOT NULL DEFAULT 0,
  last_failed_decrypt_at DATETIME(6) NULL,
  revoked BOOLEAN NOT NULL DEFAULT 0,
  ip_hash BINARY(32) NULL,
  ip_hash_key_version VARCHAR(64) NULL,
  user_agent VARCHAR(1024) NULL,
  session_blob LONGBLOB NULL,
  UNIQUE KEY uq_sessions_token_hash (token_hash),
  INDEX idx_sessions_user_created (user_id, created_at),
  INDEX idx_sessions_user (user_id),
  INDEX idx_sessions_expires_at (expires_at),
  INDEX idx_sessions_last_seen (last_seen_at),
  INDEX idx_sessions_token_hash_key (token_hash_key_version)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
