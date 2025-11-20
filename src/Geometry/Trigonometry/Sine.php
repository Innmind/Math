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

    #[\Override]
    public function value(): int|float
    {
        return $this->sine()->value();
    }

    #[\Override]
    public function equals(Number $number): bool
    {
        return $this->sine()->equals($number);
    }

    #[\Override]
    public function higherThan(Number $number): bool
    {
        return $this->sine()->higherThan($number);
    }

    #[\Override]
    public function add(Number $number): Number
    {
        return $this->sine()->add($number);
    }

    #[\Override]
    public function subtract(Number $number): Number
    {
        return $this->sine()->subtract($number);
    }

    #[\Override]
    public function divideBy(Number $number): Number
    {
        return $this->sine()->divideBy($number);
    }

    #[\Override]
    public function multiplyBy(Number $number): Number
    {
        return $this->sine()->multiplyBy($number);
    }

    #[\Override]
    public function roundUp(int $precision = 0): Number
    {
        return $this->sine()->roundUp($precision);
    }

    #[\Override]
    public function roundDown(int $precision = 0): Number
    {
        return $this->sine()->roundDown($precision);
    }

    #[\Override]
    public function roundEven(int $precision = 0): Number
    {
        return $this->sine()->roundEven($precision);
    }

    #[\Override]
    public function roundOdd(int $precision = 0): Number
    {
        return $this->sine()->roundOdd($precision);
    }

    #[\Override]
    public function floor(): Number
    {
        return $this->sine()->floor();
    }

    #[\Override]
    public function ceil(): Number
    {
        return $this->sine()->ceil();
    }

    #[\Override]
    public function modulo(Number $modulus): Number
    {
        return $this->sine()->modulo($modulus);
    }

    #[\Override]
    public function absolute(): Number
    {
        return $this->sine()->absolute();
    }

    #[\Override]
    public function power(Number $power): Number
    {
        return $this->sine()->power($power);
    }

    #[\Override]
    public function squareRoot(): Number
    {
        return $this->sine()->squareRoot();
    }

    #[\Override]
    public function exponential(): Number
    {
        return $this->sine()->exponential();
    }

    #[\Override]
    public function binaryLogarithm(): Number
    {
        return $this->sine()->binaryLogarithm();
    }

    #[\Override]
    public function naturalLogarithm(): Number
    {
        return $this->sine()->naturalLogarithm();
    }

    #[\Override]
    public function commonLogarithm(): Number
    {
        return $this->sine()->commonLogarithm();
    }

    #[\Override]
    public function signum(): Number
    {
        return $this->sine()->signum();
    }

    #[\Override]
    public function collapse(): Number
    {
        return $this;
    }

    #[\Override]
    public function toString(): string
    {
        return \sprintf('sin(%s)', $this->degree->toString());
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
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
