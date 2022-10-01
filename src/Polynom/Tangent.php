<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use Innmind\Math\Algebra\{
    Number,
    Real,
};

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
        return $this
            ->derivative
            ->multiplyBy($x->subtract($this->abscissa))
            ->add($this->intercept);
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
        return Real::of(0.000000000001);
    }
}
