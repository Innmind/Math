<?php
declare(strict_types = 1);

namespace Innmind\Math\Statistics;

use function Innmind\Math\asc;
use Innmind\Math\{
    Algebra\Number,
    Exception\LogicException,
};
use Innmind\Immutable\{
    Sequence,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class Scope
{
    private Number $result;

    private function __construct(
        Number $first,
        Number $second,
        Number ...$values,
    ) {
        $sequence = Sequence::of($first, $second, ...$values)->sort(asc(...));

        $this->result = Maybe::all($sequence->last(), $sequence->first())
            ->map(static fn(Number $last, Number $first) => $last->subtract($first))
            ->match(
                static fn($result) => $result,
                static fn() => throw new LogicException('Unreachable'),
            );
    }

    /**
     * @psalm-pure
     */
    public static function of(
        Number $first,
        Number $second,
        Number ...$values,
    ): self {
        return new self($first, $second, ...$values);
    }

    public function result(): Number
    {
        return $this->result;
    }
}
