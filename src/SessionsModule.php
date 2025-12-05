<?php
declare(strict_types=1);

namespace BlackCat\Database\Packages\Sessions;

use BlackCat\Database\SqlDialect;
use BlackCat\Database\Contracts\ModuleInterface;
use BlackCat\Database\Support\SqlIdentifier;
use BlackCat\Database\Support\SqlDirectoryRunner;
use BlackCat\Database\Support\SchemaIntrospector;
use BlackCat\Core\Database as Database;

final class SessionsModule implements ModuleInterface
{
    public function name(): string { return 'table-sessions'; }
    public function table(): string { return 'sessions'; }
    public function version(): string { return '1.0.0'; }

    /** @return string[] */
    public function dialects(): array { return [ 'mysql', 'postgres' ]; }
    /** @return string[] */
    public function dependencies(): array { return [ 'table-users' ]; }

    public static function contractView(): string { return 'vw_sessions'; }

    public function install(Database $db, SqlDialect $d): void
    {
        // 1) Run schema files from ../schema for the dialect (NNN_*.sql order respected)
        SqlDirectoryRunner::run($db, $d, __DIR__ . '/../schema');

        // 2) Contract view = SELECT * FROM <table>
        $table = SqlIdentifier::qi($db, $this->table());
        $view  = SqlIdentifier::qi($db, self::contractView());

        if ($d->isMysql()) {
            $createViewSql = <<<'SQL'
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
SQL;
        } else {
            $createViewSql = <<<'SQL'
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
SQL;
        }

        if (\class_exists('\\BlackCat\\Database\\Support\\DdlGuard')) {
            (new \BlackCat\Database\Support\DdlGuard($db, $d))->applyCreateView($createViewSql);
        } else {
            // Prefer CREATE OR REPLACE VIEW (gentle on dependencies)
            $db->exec($createViewSql);
        }

    }

    public function upgrade(Database $db, SqlDialect $d, string $from): void
    {
        // Optional: generator may place module-specific upgrade steps here (e.g., data migrations).
    }

    /** Does not drop the table, only the contract (view). */
    public function uninstall(Database $db, SqlDialect $d): void
    {
        $qiV = SqlIdentifier::qi($db, self::contractView());
        try {
            $db->exec("DROP VIEW IF EXISTS {$qiV}" . ($d->isMysql() ? "" : " CASCADE"));
        } catch (\Throwable) {
            // swallow
        }
    }

    public function status(Database $db, SqlDialect $d): array
    {
        $table = $this->table();
        $view  = self::contractView();

        $hasTable = SchemaIntrospector::hasTable($db, $d, $table);
        $hasView  = SchemaIntrospector::hasView($db, $d, $view);

        // Quick index/FK check â€“ generator injects names (case-sensitive per DB)
        $expectedIdx = [ 'idx_sessions_active', 'idx_sessions_created_at', 'idx_sessions_expires_at', 'idx_sessions_last_seen', 'idx_sessions_token_hash_key', 'idx_sessions_user', 'idx_sessions_user_created', 'idx_sessions_user_revoked_seen' ];
        if ($d->isMysql()) {
            // Drop PG-only index naming patterns (e.g., GIN/GiST)
            $expectedIdx = array_values(array_filter(
                $expectedIdx,
                static fn(string $n): bool => !str_starts_with($n, 'gin_') && !str_starts_with($n, 'gist_')
            ));
        }
        $expectedFk  = [ 'fk_sessions_user' ];

        $haveIdx = $hasTable ? SchemaIntrospector::listIndexes($db, $d, $table)     : [];
        $haveFk  = $hasTable ? SchemaIntrospector::listForeignKeys($db, $d, $table) : [];

        $missingIdx = array_values(array_diff($expectedIdx, $haveIdx));
        $missingFk  = array_values(array_diff($expectedFk, $haveFk));

        return [
            'table'       => $hasTable,
            'view'        => $hasView,
            'missing_idx' => $missingIdx,
            'missing_fk'  => $missingFk,
            'version'     => $this->version(),
        ];
    }

    public function info(): array
    {
        return [
            'table'       => $this->table(),
            'view'        => self::contractView(),
            'columns'     => Definitions::columns(),
            'version'     => $this->version(),
            'dialects'    => [ 'mysql', 'postgres' ],
            'indexes'     => [ 'idx_sessions_active', 'idx_sessions_created_at', 'idx_sessions_expires_at', 'idx_sessions_last_seen', 'idx_sessions_token_hash_key', 'idx_sessions_user', 'idx_sessions_user_created', 'idx_sessions_user_revoked_seen' ],
            'foreignKeys' => [ 'fk_sessions_user' ],
        ];
    }
}
