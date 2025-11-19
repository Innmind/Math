<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Algebra\Number,
    Algebra\Real,
};

/**
 * Inverse of sine, such as a===Sine(ArcSine(a))
 * @psalm-immutable
 */
final class ArcSine implements Number
{
    private Number $number;

    private function __construct(Number $number)
    {
        $this->number = $number;
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $number): self
    {
        return new self($number);
    }

    public function toDegree(): Degree
    {
        return $this->arcSine();
    }

    public function value(): int|float
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

    public function roundUp(int $precision = 0): Number
    {
        return $this->arcSine()->number()->roundUp($precision);
    }

    public function roundDown(int $precision = 0): Number
    {
        return $this->arcSine()->number()->roundDown($precision);
    }

    public function roundEven(int $precision = 0): Number
    {
        return $this->arcSine()->number()->roundEven($precision);
    }

    public function roundOdd(int $precision = 0): Number
    {
        return $this->arcSine()->number()->roundOdd($precision);
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

    public function collapse(): Number
    {
        return new self($this->number->collapse());
    }

    public function toString(): string
    {
        return \sprintf('sin⁻¹(%s)', $this->number->toString());
    }

    private function arcSine(): Degree
    {
        $radians = Real::of(
            \asin(
                $this->number->value(),
            ),
        );

        return Radian::of($radians)->toDegree();
    }
}
