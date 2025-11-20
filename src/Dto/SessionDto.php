<?php
declare(strict_types=1);

namespace BlackCat\Database\Packages\Sessions\Dto;

/**
 * Simple immutable DTO with public readonly properties.
 * - No logic; just a data carrier.
 * - Strong types enforce the contract across layers.
 */
final class SessionDto implements \JsonSerializable {
    public function __construct(
        public readonly int $id,
        #[\SensitiveParameter] public readonly string $tokenHash,
        public readonly ?string $tokenHashKeyVersion,
        public readonly ?string $tokenFingerprint,
        public readonly ?\DateTimeImmutable $tokenIssuedAt,
        public readonly ?int $userId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly int $version,
        public readonly \DateTimeImmutable $lastSeenAt,
        public readonly ?\DateTimeImmutable $expiresAt,
        public readonly int $failedDecryptCount,
        public readonly ?\DateTimeImmutable $lastFailedDecryptAt,
        public readonly bool $revoked,
        #[\SensitiveParameter] public readonly ?string $ipHash,
        public readonly ?string $ipHashKeyVersion,
        public readonly ?string $userAgent,
        public readonly ?string $sessionBlob
    ) {}

    /** Suitable for serialization/logging (without large blobs). */
    public function toArray(): array {
        return get_object_vars($this);
    }

    /** toArray() without null values - for clean logging/diffs. */
    public function toArrayNonNull(): array {
        return array_filter(get_object_vars($this), static fn($v) => $v !== null);
    }

    public function jsonSerialize(): array {
       $a = $this->toArray();
       foreach ($a as $k => $v) {
           if ($v instanceof \DateTimeInterface) {
               // ISO-8601 with a timezone; switch to 'Y-m-d H:i:s.u' if needed
               $a[$k] = $v->format(\DateTimeInterface::ATOM);
           }
       }
       return $a;
   }
}
