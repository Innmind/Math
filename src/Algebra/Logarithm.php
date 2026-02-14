<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\DefinitionSet\Set;

/**
 * @psalm-immutable
 */
enum Logarithm implements Func
{
    case binary;
    case base2;
    case common;
    case base10;
    case natural;
    case baseE;

    #[\Override]
    public function __invoke(Number $x): Number
    {
        $_ = Set::exclusiveRange(
            Number::zero(),
            Number::infinite(),
        )
            ->accept($x)
            ->unwrap();

        return Number::of(match ($this) {
            self::binary, self::base2 => \log($x->value(), 2),
            self::common, self::base10 => \log10($x->value()),
            self::natural, self::baseE => \log($x->value()),
        });
    }

    #[\Override]
    public function name(): string
    {
        return match ($this) {
            self::binary, self::base2 => 'lb',
            self::common, self::base10 => 'lg',
            self::natural, self::baseE => 'ln',
        };
    }
}
