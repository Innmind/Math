<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\Number,
    Algebra\Real,
};

/**
 * Given a right-angled rectangle
 *
 * tan(angle) = oppositeSide / adjacentSide
 *
 * Where angle is the one between the adjacent side and the hypothenuse
 * @psalm-immutable
 */
final class Tangent implements Number
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

    #[\Override]
    public function value(): int|float
    {
        return $this->tangent()->value();
    }

    #[\Override]
    public function equals(Number $number): bool
    {
        return $this->tangent()->equals($number);
    }

    #[\Override]
    public function higherThan(Number $number): bool
    {
        return $this->tangent()->higherThan($number);
    }

    #[\Override]
    public function add(Number $number, Number ...$numbers): Number
    {
        return $this->tangent()->add($number, ...$numbers);
    }

    #[\Override]
    public function subtract(Number $number, Number ...$numbers): Number
    {
        return $this->tangent()->subtract($number, ...$numbers);
    }

    #[\Override]
    public function divideBy(Number $number): Number
    {
        return $this->tangent()->divideBy($number);
    }

    #[\Override]
    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return $this->tangent()->multiplyBy($number, ...$numbers);
    }

    #[\Override]
    public function roundUp(int $precision = 0): Number
    {
        return $this->tangent()->roundUp($precision);
    }

    #[\Override]
    public function roundDown(int $precision = 0): Number
    {
        return $this->tangent()->roundDown($precision);
    }

    #[\Override]
    public function roundEven(int $precision = 0): Number
    {
        return $this->tangent()->roundEven($precision);
    }

    #[\Override]
    public function roundOdd(int $precision = 0): Number
    {
        return $this->tangent()->roundOdd($precision);
    }

    #[\Override]
    public function floor(): Number
    {
        return $this->tangent()->floor();
    }

    #[\Override]
    public function ceil(): Number
    {
        return $this->tangent()->ceil();
    }

    #[\Override]
    public function modulo(Number $modulus): Number
    {
        return $this->tangent()->modulo($modulus);
    }

    #[\Override]
    public function absolute(): Number
    {
        return $this->tangent()->absolute();
    }

    #[\Override]
    public function power(Number $power): Number
    {
        return $this->tangent()->power($power);
    }

    #[\Override]
    public function squareRoot(): Number
    {
        return $this->tangent()->squareRoot();
    }

    #[\Override]
    public function exponential(): Number
    {
        return $this->tangent()->exponential();
    }

    #[\Override]
    public function binaryLogarithm(): Number
    {
        return $this->tangent()->binaryLogarithm();
    }

    #[\Override]
    public function naturalLogarithm(): Number
    {
        return $this->tangent()->naturalLogarithm();
    }

    #[\Override]
    public function commonLogarithm(): Number
    {
        return $this->tangent()->commonLogarithm();
    }

    #[\Override]
    public function signum(): Number
    {
        return $this->tangent()->signum();
    }

    #[\Override]
    public function collapse(): Number
    {
        return $this;
    }

    #[\Override]
    public function toString(): string
    {
        return \sprintf('tan(%s)', $this->degree->toString());
    }

    private function tangent(): Number
    {
        return Real::of(
            \tan(
                $this->degree->toRadian()->number()->value(),
            ),
        );
    }
}
