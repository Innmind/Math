<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

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
        ?Number $limit = null,
    ) {
        $this->polynom = $polynom;
        $this->derivative = $polynom->derived($abscissa, $limit);
        $this->abscissa = $abscissa;
        $this->intercept = $polynom($abscissa);
    }

    #[\NoDiscard]
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
    #[\NoDiscard]
    public static function of(
        Polynom $polynom,
        Number $abscissa,
        ?Number $limit = null,
    ): self {
        return new self($polynom, $abscissa, $limit);
    }

    #[\NoDiscard]
    public function polynom(): Polynom
    {
        return $this->polynom;
    }

    #[\NoDiscard]
    public function abscissa(): Number
    {
        return $this->abscissa;
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function limit(): Number
    {
        return Number::of(0.000000000001);
    }
}
