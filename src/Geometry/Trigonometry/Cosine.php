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
 * cos(angle) = adjacentSide / hypothenuse
 *
 * Where angle is the one between the adjacent side and the hypothenuse
 * @psalm-immutable
 */
final class Cosine implements Number
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
        return $this->cosine()->value();
    }

    #[\Override]
    public function equals(Number $number): bool
    {
        return $this->cosine()->equals($number);
    }

    #[\Override]
    public function higherThan(Number $number): bool
    {
        return $this->cosine()->higherThan($number);
    }

    #[\Override]
    public function add(Number $number, Number ...$numbers): Number
    {
        return $this->cosine()->add($number, ...$numbers);
    }

    #[\Override]
    public function subtract(Number $number, Number ...$numbers): Number
    {
        return $this->cosine()->subtract($number, ...$numbers);
    }

    #[\Override]
    public function divideBy(Number $number): Number
    {
        return $this->cosine()->divideBy($number);
    }

    #[\Override]
    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return $this->cosine()->multiplyBy($number, ...$numbers);
    }

    #[\Override]
    public function roundUp(int $precision = 0): Number
    {
        return $this->cosine()->roundUp($precision);
    }

    #[\Override]
    public function roundDown(int $precision = 0): Number
    {
        return $this->cosine()->roundDown($precision);
    }

    #[\Override]
    public function roundEven(int $precision = 0): Number
    {
        return $this->cosine()->roundEven($precision);
    }

    #[\Override]
    public function roundOdd(int $precision = 0): Number
    {
        return $this->cosine()->roundOdd($precision);
    }

    #[\Override]
    public function floor(): Number
    {
        return $this->cosine()->floor();
    }

    #[\Override]
    public function ceil(): Number
    {
        return $this->cosine()->ceil();
    }

    #[\Override]
    public function modulo(Number $modulus): Number
    {
        return $this->cosine()->modulo($modulus);
    }

    #[\Override]
    public function absolute(): Number
    {
        return $this->cosine()->absolute();
    }

    #[\Override]
    public function power(Number $power): Number
    {
        return $this->cosine()->power($power);
    }

    #[\Override]
    public function squareRoot(): Number
    {
        return $this->cosine()->squareRoot();
    }

    #[\Override]
    public function exponential(): Number
    {
        return $this->cosine()->exponential();
    }

    #[\Override]
    public function binaryLogarithm(): Number
    {
        return $this->cosine()->binaryLogarithm();
    }

    #[\Override]
    public function naturalLogarithm(): Number
    {
        return $this->cosine()->naturalLogarithm();
    }

    #[\Override]
    public function commonLogarithm(): Number
    {
        return $this->cosine()->commonLogarithm();
    }

    #[\Override]
    public function signum(): Number
    {
        return $this->cosine()->signum();
    }

    #[\Override]
    public function collapse(): Number
    {
        return $this;
    }

    #[\Override]
    public function toString(): string
    {
        return \sprintf('cos(%s)', $this->degree->toString());
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
    }

    private function cosine(): Number
    {
        return Real::of(
            \cos(
                $this->degree->toRadian()->number()->value(),
            ),
        );
    }
}
