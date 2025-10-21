# Definition – sessions

Active/expired sessions and their lifecycle.

## Columns
| Column | Type | Null | Default | Description | Notes |
|-------:|:-----|:----:|:--------|:------------|:------|
| id | BIGINT UNSIGNED | — | — | Surrogate primary key. |  |
| token_hash | BINARY(32) | NO | — | Hashed session token. | PII: hashed |
| token_hash_key_version | VARCHAR(64) | YES | — | Key version for token_hash. |  |
| token_fingerprint | BINARY(32) | YES | — | Stable token fingerprint (hashed). | PII: hashed |
| token_issued_at | DATETIME(6) | YES | — | Original token issue time (UTC). |  |
| user_id | BIGINT UNSIGNED | YES | — | User (FK users.id), optional. |  |
| created_at | DATETIME(6) | NO | CURRENT_TIMESTAMP(6) | Creation timestamp (UTC). |  |
| last_seen_at | DATETIME(6) | NO | CURRENT_TIMESTAMP(6) | Last activity timestamp (UTC). |  |
| expires_at | DATETIME(6) | YES | — | Expiration timestamp (UTC). |  |
| failed_decrypt_count | INT UNSIGNED | NO | 0 | Number of failed decrypt attempts. |  |
| last_failed_decrypt_at | DATETIME(6) | YES | — | Timestamp of last failed decrypt. |  |
| revoked | BOOLEAN | NO | 0 | Revocation flag. |  |
| ip_hash | BINARY(32) | YES | — | Hashed client IP. | PII: hashed |
| ip_hash_key_version | VARCHAR(64) | YES | — | Key version for ip_hash. |  |
| user_agent | VARCHAR(1024) | YES | — | Client user agent. |  |
| session_blob | LONGBLOB | YES | — | Optional encrypted session payload. | PII: encrypted |
