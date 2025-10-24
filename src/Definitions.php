<?php
declare(strict_types=1);

namespace BlackCat\Database\Packages\Sessions;

final class Definitions {
    // --- základní metadata ---
    public static function table(): string { return 'sessions'; }
    public static function contractView(): string { return 'vw_sessions'; }
    /** @return string[] */
    public static function columns(): array { return [ 'id', 'token_hash', 'token_hash_key_version', 'token_fingerprint', 'token_issued_at', 'user_id', 'created_at', 'last_seen_at', 'expires_at', 'failed_decrypt_count', 'last_failed_decrypt_at', 'revoked', 'ip_hash', 'ip_hash_key_version', 'user_agent', 'session_blob' ]; }
    public static function pk(): string { return 'id'; }

    // --- volitelná metadata (mohou být prázdná) ---
    public static function softDeleteColumn(): ?string {
        $c = ''; return $c !== '' ? $c : null;
    }
    public static function updatedAtColumn(): ?string {
        $c = ''; return $c !== '' ? $c : null;
    }
    public static function versionColumn(): ?string {
        $c = ''; return $c !== '' ? $c : null; // pro optimistic locking
    }
    /** např. "created_at DESC, id DESC" */
    public static function defaultOrder(): ?string {
        $c = 'created_at DESC, id DESC'; return $c !== '' ? $c : null;
    }
    /** @return array<int,array<int,string>> seznam unikátních klíčů (sloupcových kombinací) */
    public static function uniqueKeys(): array { return []; }
    /** @return string[] JSON sloupce kvůli castům/operacím */
    public static function jsonColumns(): array { return []; }

    // --- pomocníci ---
    public static function hasColumn(string $col): bool {
        static $set = null;
        if ($set === null) { $set = array_fill_keys(self::columns(), true); }
        return isset($set[$col]);
    }
}
