# 📦 Sessions

![SQL](https://img.shields.io/badge/SQL-MySQL%208.0%2B-4479A1?logo=mysql&logoColor=white) ![License](https://img.shields.io/badge/license-BlackCat%20Proprietary-red) ![Status](https://img.shields.io/badge/status-stable-informational) ![Generated](https://img.shields.io/badge/generated-from%20schema--map-blue)

<!-- Auto-generated from schema-map-postgres.psd1 @ 62c9c93 (2025-11-20T21:38:11+01:00) -->

> Schema package for table **sessions** (repo: `sessions`).

## Files
```
schema/
  001_table.sql
  020_indexes.sql
  030_foreign_keys.sql
```

## Quick apply
```bash
# Apply schema (Linux/macOS):
mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < schema/001_table.sql
mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < schema/020_indexes.sql
mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < schema/030_foreign_keys.sql
```

```powershell
# Apply schema (Windows PowerShell):
mysql -h $env:DB_HOST -u $env:DB_USER -p$env:DB_PASS $env:DB_NAME < schema/001_table.sql
mysql -h $env:DB_HOST -u $env:DB_USER -p$env:DB_PASS $env:DB_NAME < schema/020_indexes.sql
mysql -h $env:DB_HOST -u $env:DB_USER -p$env:DB_PASS $env:DB_NAME < schema/030_foreign_keys.sql
```

## Docker quickstart
```bash
# Spin up a throwaway MySQL and apply just this package:
docker run --rm -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=app -p 3307:3306 -d mysql:8
sleep 15
mysql -h 127.0.0.1 -P 3307 -u root -proot app < schema/001_table.sql
mysql -h 127.0.0.1 -P 3307 -u root -proot app < schema/020_indexes.sql
mysql -h 127.0.0.1 -P 3307 -u root -proot app < schema/030_foreign_keys.sql
```

## Columns
| Column | Type | Null | Default | Extra |
|-------:|:-----|:----:|:--------|:------|
| id | BIGINT | — | AS | PK |
| token_hash | BYTEA | NO | — |  |
| token_hash_key_version | VARCHAR(64) | YES | — |  |
| token_fingerprint | BYTEA | YES | — |  |
| token_issued_at | TIMESTAMPTZ(6) | YES | — |  |
| user_id | BIGINT | YES | — |  |
| created_at | TIMESTAMPTZ(6) | NO | CURRENT_TIMESTAMP(6) |  |
| version | INTEGER | NO | 0 |  |
| last_seen_at | TIMESTAMPTZ(6) | NO | CURRENT_TIMESTAMP(6) |  |
| expires_at | TIMESTAMPTZ(6) | YES | — |  |
| failed_decrypt_count | INTEGER | NO | 0 |  |
| last_failed_decrypt_at | TIMESTAMPTZ(6) | YES | — |  |
| revoked | BOOLEAN | NO | FALSE |  |
| ip_hash | BYTEA | YES | — |  |
| ip_hash_key_version | VARCHAR(64) | YES | — |  |
| user_agent | VARCHAR(1024) | YES | — |  |
| session_blob | BYTEA | YES | — |  |

## Relationships
- FK → **users** via (user_id) (ON DELETE SET NULL).

```mermaid
erDiagram
  SESSIONS {
    INT id PK
    BYTEA token_hash
    VARCHAR token_hash_key_version
    BYTEA token_fingerprint
    TIMESTAMPTZ token_issued_at
    INT user_id
    TIMESTAMPTZ created_at
    INTEGER version
    TIMESTAMPTZ last_seen_at
    TIMESTAMPTZ expires_at
    INTEGER failed_decrypt_count
    TIMESTAMPTZ last_failed_decrypt_at
    BOOLEAN revoked
    BYTEA ip_hash
    VARCHAR ip_hash_key_version
    VARCHAR user_agent
    BYTEA session_blob
  }
  SESSIONS }o--|| USERS : "user_id"
```

## Indexes
- 8 deferred index statement(s) in schema/020_indexes.sql.

## Notes
- Generated from the umbrella repository **blackcat-database** using `scripts/schema-map.psd1`.
- To change the schema, update the map and re-run the generators.

## License
Distributed under the **BlackCat Store Proprietary License v1.0**. See `LICENSE`.
