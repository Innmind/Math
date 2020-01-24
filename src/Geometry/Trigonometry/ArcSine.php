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
 * Inverse of sine, such as a===Sine(ArcSine(a))
 */
final class ArcSine implements Number
{
    private Number $number;
    private ?Degree $arcSine = null;

    public function __construct(Number $number)
    {
        $this->number = $number;
    }

    public function toDegree(): Degree
    {
        return $this->arcSine();
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->arcSine()->number()->value();
    }

    public function equals(Number $number): bool
    {
        return $this->arcSine()->number()->equals($number);
    }

    public function higherThan(Number $number): bool
    {
        return $this->arcSine()->number()->higherThan($number);
    }

    public function add(Number $number, Number ...$numbers): Number
    {
        return $this->arcSine()->number()->add($number, ...$numbers);
    }

    public function subtract(Number $number, Number ...$numbers): Number
    {
        return $this->arcSine()->number()->subtract($number, ...$numbers);
    }

    public function divideBy(Number $number): Number
    {
        return $this->arcSine()->number()->divideBy($number);
    }

    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return $this->arcSine()->number()->multiplyBy($number, ...$numbers);
    }

    public function round(int $precision = 0, string $mode = Round::UP): Number
    {
        return $this->arcSine()->number()->round($precision, $mode);
    }

    public function floor(): Number
    {
        return $this->arcSine()->number()->floor();
    }

    public function ceil(): Number
    {
        return $this->arcSine()->number()->ceil();
    }

    public function modulo(Number $modulus): Number
    {
        return $this->arcSine()->number()->modulo($modulus);
    }

    public function absolute(): Number
    {
        return $this->arcSine()->number()->absolute();
    }

    public function power(Number $power): Number
    {
        return $this->arcSine()->number()->power($power);
    }

    public function squareRoot(): Number
    {
        return $this->arcSine()->number()->squareRoot();
    }

    public function exponential(): Number
    {
        return $this->arcSine()->number()->exponential();
    }

    public function binaryLogarithm(): Number
    {
        return $this->arcSine()->number()->binaryLogarithm();
    }

    public function naturalLogarithm(): Number
    {
        return $this->arcSine()->number()->naturalLogarithm();
    }

    public function commonLogarithm(): Number
    {
        return $this->arcSine()->number()->commonLogarithm();
    }

    public function signum(): Number
    {
        return $this->arcSine()->number()->signum();
    }

    private function arcSine(): Degree
    {
        if ($this->arcSine) {
            return $this->arcSine;
        }

        $radians = new Number\Number(
            asin(
                $this->number->value()
            )
        );

        return $this->arcSine = (new Radian($radians))->toDegree();
    }

    public function toString(): string
    {
        return sprintf('sin⁻¹(%s)', $this->number->toString());
    }
}
