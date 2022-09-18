<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use function Innmind\Math\{
    add,
    multiply,
};
use Innmind\Math\Algebra\Number;

/**
 * @psalm-immutable
 */
final class Tangent
{
    private Polynom $polynom;
    private Number $derivative;
    private Number $abscissa;
    private Number $intercept;

    private function __construct(
        Polynom $polynom,
        Number $abscissa,
        Number $limit = null,
    ) {
        $this->polynom = $polynom;
        $this->derivative = $polynom->derived($abscissa, $limit);
        $this->abscissa = $abscissa;
        $this->intercept = $polynom($abscissa);
    }

    public function __invoke(Number $x): Number
    {
        return add(
            multiply(
                $this->derivative,
                $x->subtract($this->abscissa),
            ),
            $this->intercept,
        );
    }

    /**
     * @psalm-pure
     */
    public static function of(
        Polynom $polynom,
        Number $abscissa,
        Number $limit = null,
    ): self {
        return new self($polynom, $abscissa, $limit);
    }

    public function polynom(): Polynom
    {
        return $this->polynom;
    }

    public function abscissa(): Number
    {
        return $this->abscissa;
    }

    /**
     * @psalm-pure
     */
    public static function limit(): Number
    {
        return Number\Number::of(0.000000000001);
    }
}
