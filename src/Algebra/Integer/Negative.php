<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra\Integer;

use Innmind\Math\Algebra\Integer;

/**
 * @psalm-immutable
 */
final class Negative extends Integer
{
    #[\Override]
    public function decrement(): self
    {
        /** @var self */
        return self::of($this->value() - 1);
    }
}
