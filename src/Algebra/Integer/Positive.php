<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra\Integer;

use Innmind\Math\Algebra\Integer;

/**
 * @psalm-immutable
 */
final class Positive extends Integer
{
    /**
     * @return positive-int
     */
    public function value(): int
    {
        /** @var positive-int */
        return parent::value();
    }

    public function increment(): self
    {
        return self::positive($this->value() + 1);
    }
}
