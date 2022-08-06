<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Algebra\Number,
    Algebra\Round,
};

/**
 * Inverse of tangent, such as a===Tangent(ArcTangent(a))
 */
final class ArcTangent implements Number
{
    private Number $number;

    public function __construct(Number $number)
    {
        $this->number = $number;
    }

    public function toDegree(): Degree
    {
        return $this->arcTangent();
    }

    public function value(): int|float
    {
        return $this->arcTangent()->number()->value();
    }

    public function equals(Number $number): bool
    {
        return $this->arcTangent()->number()->equals($number);
    }

    public function higherThan(Number $number): bool
    {
        return $this->arcTangent()->number()->higherThan($number);
    }

    public function add(
        Number $number,
        Number ...$numbers,
    ): Number {
        return $this->arcTangent()->number()->add($number, ...$numbers);
    }

    public function subtract(
        Number $number,
        Number ...$numbers,
    ): Number {
        return $this->arcTangent()->number()->subtract($number, ...$numbers);
    }

    public function divideBy(Number $number): Number
    {
        return $this->arcTangent()->number()->divideBy($number);
    }

    public function multiplyBy(
        Number $number,
        Number ...$numbers,
    ): Number {
        return $this->arcTangent()->number()->multiplyBy($number, ...$numbers);
    }

    public function roundUp(int $precision = 0): Number
    {
        return $this->arcTangent()->number()->roundUp($precision);
    }

    public function roundDown(int $precision = 0): Number
    {
        return $this->arcTangent()->number()->roundDown($precision);
    }

    public function roundEven(int $precision = 0): Number
    {
        return $this->arcTangent()->number()->roundEven($precision);
    }

    public function roundOdd(int $precision = 0): Number
    {
        return $this->arcTangent()->number()->roundOdd($precision);
    }

    public function floor(): Number
    {
        return $this->arcTangent()->number()->floor();
    }

    public function ceil(): Number
    {
        return $this->arcTangent()->number()->ceil();
    }

    public function modulo(Number $modulus): Number
    {
        return $this->arcTangent()->number()->modulo($modulus);
    }

    public function absolute(): Number
    {
        return $this->arcTangent()->number()->absolute();
    }

    public function power(Number $power): Number
    {
        return $this->arcTangent()->number()->power($power);
    }

    public function squareRoot(): Number
    {
        return $this->arcTangent()->number()->squareRoot();
    }

    public function exponential(): Number
    {
        return $this->arcTangent()->number()->exponential();
    }

    public function binaryLogarithm(): Number
    {
        return $this->arcTangent()->number()->binaryLogarithm();
    }

    public function naturalLogarithm(): Number
    {
        return $this->arcTangent()->number()->naturalLogarithm();
    }

    public function commonLogarithm(): Number
    {
        return $this->arcTangent()->number()->commonLogarithm();
    }

    public function signum(): Number
    {
        return $this->arcTangent()->number()->signum();
    }

    public function collapse(): Number
    {
        return $this;
    }

    public function toString(): string
    {
        return \sprintf('tan⁻¹(%s)', $this->number->toString());
    }

    private function arcTangent(): Degree
    {
        $radians = new Number\Number(
            \atan(
                $this->number->value(),
            ),
        );

        return (new Radian($radians))->toDegree();
    }
}
