<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Algebra\Number,
    Algebra\Round
};

/**
 * Inverse of cosine, such as a===Cosine(ArcCosine(a))
 */
final class ArcCosine implements Number
{
    private $number;
    private $arcCosine;

    public function __construct(Number $number)
    {
        $this->number = $number;
    }

    public function toDegree(): Degree
    {
        return $this->arcCosine();
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->arcCosine()->number()->value();
    }

    public function equals(Number $number): bool
    {
        return $this->arcCosine()->number()->equals($number);
    }

    public function higherThan(Number $number): bool
    {
        return $this->arcCosine()->number()->higherThan($number);
    }

    public function add(Number $number, Number ...$numbers): Number
    {
        return $this->arcCosine()->number()->add($number, ...$numbers);
    }

    public function subtract(Number $number, Number ...$numbers): Number
    {
        return $this->arcCosine()->number()->subtract($number, ...$numbers);
    }

    public function divideBy(Number $number): Number
    {
        return $this->arcCosine()->number()->divideBy($number);
    }

    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return $this->arcCosine()->number()->multiplyBy($number, ...$numbers);
    }

    public function round(int $precision = 0, string $mode = Round::UP): Number
    {
        return $this->arcCosine()->number()->round($precision, $mode);
    }

    public function floor(): Number
    {
        return $this->arcCosine()->number()->floor();
    }

    public function ceil(): Number
    {
        return $this->arcCosine()->number()->ceil();
    }

    public function modulo(Number $modulus): Number
    {
        return $this->arcCosine()->number()->modulo($modulus);
    }

    public function absolute(): Number
    {
        return $this->arcCosine()->number()->absolute();
    }

    public function power(Number $power): Number
    {
        return $this->arcCosine()->number()->power($power);
    }

    public function squareRoot(): Number
    {
        return $this->arcCosine()->number()->squareRoot();
    }

    public function exponential(): Number
    {
        return $this->arcCosine()->number()->exponential();
    }

    public function binaryLogarithm(): Number
    {
        return $this->arcCosine()->number()->binaryLogarithm();
    }

    public function naturalLogarithm(): Number
    {
        return $this->arcCosine()->number()->naturalLogarithm();
    }

    public function commonLogarithm(): Number
    {
        return $this->arcCosine()->number()->commonLogarithm();
    }

    public function signum(): Number
    {
        return $this->arcCosine()->number()->signum();
    }

    private function arcCosine(): Degree
    {
        if ($this->arcCosine) {
            return $this->arcCosine;
        }

        $radians = new Number\Number(
            acos(
                $this->number->value()
            )
        );

        return $this->arcCosine = (new Radian($radians))->toDegree();
    }

    public function __toString(): string
    {
        return sprintf('cos⁻¹(%s)', $this->number);
    }
}
