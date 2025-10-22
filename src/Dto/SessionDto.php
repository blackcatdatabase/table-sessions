<?php
declare(strict_types=1);

namespace BlackCat\Database\Packages\Sessions\Dto;

/**
 * Jednoduché, neměnné DTO s veřejnými readonly vlastnostmi.
 * - Žádná logika; pouze nosič dat.
 * - Silné typy drží kontrakt napříč vrstvami.
 */
final class SessionDto {
    public function __construct(
        public readonly ?int $id,
        public readonly string $tokenHash,
        public readonly ?string $tokenHashKeyVersion,
        public readonly ?string $tokenFingerprint,
        public readonly ?\DateTimeImmutable $tokenIssuedAt,
        public readonly ?int $userId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $lastSeenAt,
        public readonly ?\DateTimeImmutable $expiresAt,
        public readonly int $failedDecryptCount,
        public readonly ?\DateTimeImmutable $lastFailedDecryptAt,
        public readonly bool $revoked,
        public readonly ?string $ipHash,
        public readonly ?string $ipHashKeyVersion,
        public readonly ?string $userAgent,
        public readonly ?string $sessionBlob
    ) {}

    /** Vhodné pro serializaci/logování (bez binárních/velkých blobů). */
    public function toArray(): array {
        // get_object_vars funguje dobře s public readonly vlastnostmi
        return get_object_vars($this);
    }
}
