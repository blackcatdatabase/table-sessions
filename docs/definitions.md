# sessions

Active/expired sessions and their lifecycle.

## Columns
| Column | Type | Null | Default | Description | Crypto |
| --- | --- | --- | --- | --- | --- |
| id | BIGINT | NO |  | Surrogate primary key. |  |
| token_hash | mysql: BINARY(32) / postgres: BYTEA | NO |  | Hashed session token. | `hmac`<br/>ctx: `db.hmac.sessions.token_hash`<br/>kv: `token_hash_key_version` |
| token_hash_key_version | VARCHAR(64) | YES |  | Key version for token_hash. | key version for: `token_hash` |
| token_fingerprint | mysql: BINARY(32) / postgres: BYTEA | YES |  | Stable token fingerprint (hashed). |  |
| token_issued_at | mysql: DATETIME(6) / postgres: TIMESTAMPTZ(6) | YES |  | Original token issue time (UTC). |  |
| user_id | BIGINT | YES |  | User (FK users.id), optional. |  |
| created_at | mysql: DATETIME(6) / postgres: TIMESTAMPTZ(6) | NO | CURRENT_TIMESTAMP(6) | Creation timestamp (UTC). |  |
| version | mysql: INT / postgres: INTEGER | NO | 0 | Optimistic locking version counter. |  |
| last_seen_at | mysql: DATETIME(6) / postgres: TIMESTAMPTZ(6) | NO | CURRENT_TIMESTAMP(6) | Last activity timestamp (UTC). |  |
| expires_at | mysql: DATETIME(6) / postgres: TIMESTAMPTZ(6) | YES |  | Expiration timestamp (UTC). |  |
| failed_decrypt_count | mysql: INT / postgres: INTEGER | NO | 0 | Number of failed decrypt attempts. |  |
| last_failed_decrypt_at | mysql: DATETIME(6) / postgres: TIMESTAMPTZ(6) | YES |  | Timestamp of last failed decrypt. |  |
| revoked | BOOLEAN | NO | mysql: 0 / postgres: FALSE | Revocation flag. |  |
| ip_hash | mysql: BINARY(32) / postgres: BYTEA | YES |  | Hashed client IP. | `hmac`<br/>ctx: `db.hmac.sessions.ip_hash`<br/>kv: `ip_hash_key_version` |
| ip_hash_key_version | VARCHAR(64) | YES |  | Key version for ip_hash. | key version for: `ip_hash` |
| user_agent | VARCHAR(1024) | YES |  | Client user agent. |  |
| session_blob | mysql: LONGBLOB / postgres: BYTEA | YES |  | Optional encrypted session payload. |  |

## Engine Details

### mysql

Unique keys:
| Name | Columns |
| --- | --- |
| uq_sessions_token_hash | token_hash |

Indexes:
| Name | Columns | SQL |
| --- | --- | --- |
| idx_sessions_active | revoked,expires_at,user_id | CREATE INDEX idx_sessions_active ON sessions (revoked, expires_at, user_id) |
| idx_sessions_created_at | created_at | CREATE INDEX idx_sessions_created_at ON sessions (created_at) |
| idx_sessions_expires_at | expires_at | CREATE INDEX idx_sessions_expires_at ON sessions (expires_at) |
| idx_sessions_last_seen | last_seen_at | CREATE INDEX idx_sessions_last_seen ON sessions (last_seen_at) |
| idx_sessions_token_hash_key | token_hash_key_version | CREATE INDEX idx_sessions_token_hash_key ON sessions (token_hash_key_version) |
| idx_sessions_user | user_id | CREATE INDEX idx_sessions_user ON sessions (user_id) |
| idx_sessions_user_created | user_id,created_at | CREATE INDEX idx_sessions_user_created ON sessions (user_id, created_at) |
| idx_sessions_user_revoked_seen | user_id,revoked,last_seen_atDESC | CREATE INDEX idx_sessions_user_revoked_seen ON sessions (user_id, revoked, last_seen_at DESC) |
| uq_sessions_token_hash | token_hash | UNIQUE KEY uq_sessions_token_hash (token_hash) |

Foreign keys:
| Name | Columns | References | Actions |
| --- | --- | --- | --- |
| fk_sessions_user | user_id | users(id) | ON DELETE SET |

### postgres

Unique keys:
| Name | Columns |
| --- | --- |
| uq_sessions_token_hash | token_hash |

Indexes:
| Name | Columns | SQL |
| --- | --- | --- |
| idx_sessions_active | revoked,expires_at,user_id | CREATE INDEX IF NOT EXISTS idx_sessions_active ON sessions (revoked, expires_at, user_id) |
| idx_sessions_created_at | created_at | CREATE INDEX IF NOT EXISTS idx_sessions_created_at ON sessions (created_at) |
| idx_sessions_expires_at | expires_at | CREATE INDEX IF NOT EXISTS idx_sessions_expires_at ON sessions (expires_at) |
| idx_sessions_last_seen | last_seen_at | CREATE INDEX IF NOT EXISTS idx_sessions_last_seen ON sessions (last_seen_at) |
| idx_sessions_token_hash_key | token_hash_key_version | CREATE INDEX IF NOT EXISTS idx_sessions_token_hash_key ON sessions (token_hash_key_version) |
| idx_sessions_user | user_id | CREATE INDEX IF NOT EXISTS idx_sessions_user ON sessions (user_id) |
| idx_sessions_user_created | user_id,created_at | CREATE INDEX IF NOT EXISTS idx_sessions_user_created ON sessions (user_id, created_at) |
| idx_sessions_user_revoked_seen | user_id,revoked,last_seen_atDESC | CREATE INDEX IF NOT EXISTS idx_sessions_user_revoked_seen ON sessions (user_id, revoked, last_seen_at DESC) |
| uq_sessions_token_hash | token_hash | CONSTRAINT uq_sessions_token_hash UNIQUE (token_hash) |

Foreign keys:
| Name | Columns | References | Actions |
| --- | --- | --- | --- |
| fk_sessions_user | user_id | users(id) | ON DELETE SET |

## Engine differences

## Views
| View | Engine | Flags | File |
| --- | --- | --- | --- |
| vw_sessions | mysql | algorithm=MERGE, security=INVOKER | [../schema/040_views.mysql.sql](../schema/040_views.mysql.sql) |
| vw_sessions_active_by_user | mysql | algorithm=TEMPTABLE, security=INVOKER | [../schema/040_views_joins.mysql.sql](../schema/040_views_joins.mysql.sql) |
| vw_sessions | postgres |  | [../schema/040_views.postgres.sql](../schema/040_views.postgres.sql) |
| vw_sessions_active_by_user | postgres |  | [../schema/040_views_joins.postgres.sql](../schema/040_views_joins.postgres.sql) |
