<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\Number,
    Algebra\Round,
    Algebra\Real,
};

/**
 * Given a right-angled rectangle
 *
 * sin(angle) = oppositeSide / hypothenuse
 *
 * Where angle is the one between the adjacent side and the hypothenuse
 * @psalm-immutable
 */
final class Sine implements Number
{
    private Degree $degree;

    private function __construct(Degree $degree)
    {
        $this->degree = $degree;
    }

    /**
     * @psalm-pure
     */
    public static function of(Degree $degree): self
    {
        return new self($degree);
    }

    public function value(): int|float
    {
        return $this->sine()->value();
    }

    public function equals(Number $number): bool
    {
        return $this->sine()->equals($number);
    }

    public function higherThan(Number $number): bool
    {
        return $this->sine()->higherThan($number);
    }

    public function add(Number $number, Number ...$numbers): Number
    {
        return $this->sine()->add($number, ...$numbers);
    }

    public function subtract(Number $number, Number ...$numbers): Number
    {
        return $this->sine()->subtract($number, ...$numbers);
    }

    public function divideBy(Number $number): Number
    {
        return $this->sine()->divideBy($number);
    }

    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return $this->sine()->multiplyBy($number, ...$numbers);
    }

    public function roundUp(int $precision = 0): Number
    {
        return $this->sine()->roundUp($precision);
    }

    public function roundDown(int $precision = 0): Number
    {
        return $this->sine()->roundDown($precision);
    }

    public function roundEven(int $precision = 0): Number
    {
        return $this->sine()->roundEven($precision);
    }

    public function roundOdd(int $precision = 0): Number
    {
        return $this->sine()->roundOdd($precision);
    }

    public function floor(): Number
    {
        return $this->sine()->floor();
    }

    public function ceil(): Number
    {
        return $this->sine()->ceil();
    }

    public function modulo(Number $modulus): Number
    {
        return $this->sine()->modulo($modulus);
    }

    public function absolute(): Number
    {
        return $this->sine()->absolute();
    }

    public function power(Number $power): Number
    {
        return $this->sine()->power($power);
    }

    public function squareRoot(): Number
    {
        return $this->sine()->squareRoot();
    }

    public function exponential(): Number
    {
        return $this->sine()->exponential();
    }

    public function binaryLogarithm(): Number
    {
        return $this->sine()->binaryLogarithm();
    }

    public function naturalLogarithm(): Number
    {
        return $this->sine()->naturalLogarithm();
    }

    public function commonLogarithm(): Number
    {
        return $this->sine()->commonLogarithm();
    }

    public function signum(): Number
    {
        return $this->sine()->signum();
    }

    public function collapse(): Number
    {
        return $this;
    }

    public function toString(): string
    {
        return \sprintf('sin(%s)', $this->degree->toString());
    }

    private function sine(): Number
    {
        return Real::of(
            \sin(
                $this->degree->toRadian()->number()->value(),
            ),
        );
    }
}
