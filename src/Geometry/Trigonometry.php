<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry;

use Innmind\Math\Algebra\{
    Number,
    Func,
};

/**
 * @psalm-immutable
 */
enum Trigonometry implements Func
{
    case arcCosine;
    case arcSine;
    case arcTangent;
    case cosine;
    case sine;
    case tangent;

    #[\Override]
    public function __invoke(Number $x): Number
    {
        return Number::of(match ($this) {
            self::arcCosine => \acos($x->value()),
            self::arcSine => \asin($x->value()),
            self::arcTangent => \atan($x->value()),
            self::cosine => \cos($x->value()),
            self::sine => \sin($x->value()),
            self::tangent => \tan($x->value()),
        });
    }

    #[\Override]
    public function name(): string
    {
        return match ($this) {
            self::arcCosine => 'cos⁻¹',
            self::arcSine => 'sin⁻¹',
            self::arcTangent => 'tan⁻¹',
            self::cosine => 'cos',
            self::sine => 'sin',
            self::tangent => 'tan',
        };
    }
}
