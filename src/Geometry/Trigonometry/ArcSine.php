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

    #[\Override]
    public function value(): int|float
    {
        return $this->arcSine()->number()->value();
    }

    #[\Override]
    public function equals(Number $number): bool
    {
        return $this->arcSine()->number()->equals($number);
    }

    #[\Override]
    public function higherThan(Number $number): bool
    {
        return $this->arcSine()->number()->higherThan($number);
    }

    #[\Override]
    public function add(Number $number, Number ...$numbers): Number
    {
        return $this->arcSine()->number()->add($number, ...$numbers);
    }

    #[\Override]
    public function subtract(Number $number, Number ...$numbers): Number
    {
        return $this->arcSine()->number()->subtract($number, ...$numbers);
    }

    #[\Override]
    public function divideBy(Number $number): Number
    {
        return $this->arcSine()->number()->divideBy($number);
    }

    #[\Override]
    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return $this->arcSine()->number()->multiplyBy($number, ...$numbers);
    }

    #[\Override]
    public function roundUp(int $precision = 0): Number
    {
        return $this->arcSine()->number()->roundUp($precision);
    }

    #[\Override]
    public function roundDown(int $precision = 0): Number
    {
        return $this->arcSine()->number()->roundDown($precision);
    }

    #[\Override]
    public function roundEven(int $precision = 0): Number
    {
        return $this->arcSine()->number()->roundEven($precision);
    }

    #[\Override]
    public function roundOdd(int $precision = 0): Number
    {
        return $this->arcSine()->number()->roundOdd($precision);
    }

    #[\Override]
    public function floor(): Number
    {
        return $this->arcSine()->number()->floor();
    }

    #[\Override]
    public function ceil(): Number
    {
        return $this->arcSine()->number()->ceil();
    }

    #[\Override]
    public function modulo(Number $modulus): Number
    {
        return $this->arcSine()->number()->modulo($modulus);
    }

    #[\Override]
    public function absolute(): Number
    {
        return $this->arcSine()->number()->absolute();
    }

    #[\Override]
    public function power(Number $power): Number
    {
        return $this->arcSine()->number()->power($power);
    }

    #[\Override]
    public function squareRoot(): Number
    {
        return $this->arcSine()->number()->squareRoot();
    }

    #[\Override]
    public function exponential(): Number
    {
        return $this->arcSine()->number()->exponential();
    }

    #[\Override]
    public function binaryLogarithm(): Number
    {
        return $this->arcSine()->number()->binaryLogarithm();
    }

    #[\Override]
    public function naturalLogarithm(): Number
    {
        return $this->arcSine()->number()->naturalLogarithm();
    }

    #[\Override]
    public function commonLogarithm(): Number
    {
        return $this->arcSine()->number()->commonLogarithm();
    }

    #[\Override]
    public function signum(): Number
    {
        return $this->arcSine()->number()->signum();
    }

    #[\Override]
    public function collapse(): Number
    {
        return new self($this->number->collapse());
    }

    #[\Override]
    public function toString(): string
    {
        return \sprintf('sin⁻¹(%s)', $this->number->toString());
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
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
