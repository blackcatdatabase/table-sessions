# 📦 Sessions

![SQL](https://img.shields.io/badge/SQL-MySQL%208.0%2B-4479A1?logo=mysql&logoColor=white) ![License](https://img.shields.io/badge/license-BlackCat%20Proprietary-red) ![Status](https://img.shields.io/badge/status-stable-informational) ![Generated](https://img.shields.io/badge/generated-from%20schema--map-blue)

> Schema package for table **sessions** (repo: $slug).

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
| id | BIGINT UNSIGNED | — | — | AUTO_INCREMENT, PK |
| token_hash | BINARY(32) | NO | — |  |
| token_hash_key_version | VARCHAR(64) | YES | — |  |
| token_fingerprint | BINARY(32) | YES | — |  |
| token_issued_at | DATETIME(6) | YES | — |  |
| user_id | BIGINT UNSIGNED | YES | — |  |
| created_at | DATETIME(6) | NO | CURRENT_TIMESTAMP(6) |  |
| last_seen_at | DATETIME(6) | NO | CURRENT_TIMESTAMP(6) |  |
| expires_at | DATETIME(6) | YES | — |  |
| failed_decrypt_count | INT UNSIGNED | NO | 0 |  |
| last_failed_decrypt_at | DATETIME(6) | YES | — |  |
| revoked | BOOLEAN | NO | 0 |  |
| ip_hash | BINARY(32) | YES | — |  |
| ip_hash_key_version | VARCHAR(64) | YES | — |  |
| user_agent | VARCHAR(1024) | YES | — |  |
| session_blob | LONGBLOB | YES | — |  |

## Relationships
- FK → **users** via (user_id) (ON DELETE SET NULL).

```mermaid
erDiagram
  SESSIONS {
    BIGINT id PK
    BINARY(32) token_hash
    VARCHAR(64) token_hash_key_version
    BINARY(32) token_fingerprint
    DATETIME(6) token_issued_at
    BIGINT user_id
    DATETIME(6) created_at
    DATETIME(6) last_seen_at
    DATETIME(6) expires_at
    INT failed_decrypt_count
    DATETIME(6) last_failed_decrypt_at
    BOOLEAN revoked
    BINARY(32) ip_hash
    VARCHAR(64) ip_hash_key_version
    VARCHAR(1024) user_agent
    LONGBLOB session_blob
  }
  SESSIONS }o--|| USERS : "user_id"
```

## Indexes
- 1 deferred index statement(s) in schema/020_indexes.sql.

## Notes
- Generated from the umbrella repository **blackcat-database** using `scripts/schema-map.psd1`.
- To change the schema, update the map and re-run the generators.

## License
Distributed under the **BlackCat Store Proprietary License v1.0**. See `LICENSE`.

