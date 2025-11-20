<!-- Auto-generated from schema-map-postgres.psd1 @ 62c9c93 (2025-11-20T21:38:11+01:00) -->
# Definition – sessions

Active/expired sessions and their lifecycle.

## Columns
| Column | Type | Null | Default | Description | Notes |
|-------:|:-----|:----:|:--------|:------------|:------|
| id | BIGINT | — | AS | Surrogate primary key. |  |
| token_hash | BYTEA | NO | — | Hashed session token. | PII: hashed |
| token_hash_key_version | VARCHAR(64) | YES | — | Key version for token_hash. |  |
| token_fingerprint | BYTEA | YES | — | Stable token fingerprint (hashed). | PII: hashed |
| token_issued_at | TIMESTAMPTZ(6) | YES | — | Original token issue time (UTC). |  |
| user_id | BIGINT | YES | — | User (FK users.id), optional. |  |
| created_at | TIMESTAMPTZ(6) | NO | CURRENT_TIMESTAMP(6) | Creation timestamp (UTC). |  |
| version | INTEGER | NO | 0 |  |  |
| last_seen_at | TIMESTAMPTZ(6) | NO | CURRENT_TIMESTAMP(6) | Last activity timestamp (UTC). |  |
| expires_at | TIMESTAMPTZ(6) | YES | — | Expiration timestamp (UTC). |  |
| failed_decrypt_count | INTEGER | NO | 0 | Number of failed decrypt attempts. |  |
| last_failed_decrypt_at | TIMESTAMPTZ(6) | YES | — | Timestamp of last failed decrypt. |  |
| revoked | BOOLEAN | NO | FALSE | Revocation flag. |  |
| ip_hash | BYTEA | YES | — | Hashed client IP. | PII: hashed |
| ip_hash_key_version | VARCHAR(64) | YES | — | Key version for ip_hash. |  |
| user_agent | VARCHAR(1024) | YES | — | Client user agent. |  |
| session_blob | BYTEA | YES | — | Optional encrypted session payload. | PII: encrypted |