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
 * Inverse of cosine, such as a===Cosine(ArcCosine(a))
 * @psalm-immutable
 */
final class ArcCosine implements Number
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
        return $this->arcCosine();
    }

    #[\Override]
    public function value(): int|float
    {
        return $this->arcCosine()->number()->value();
    }

    #[\Override]
    public function equals(Number $number): bool
    {
        return $this->arcCosine()->number()->equals($number);
    }

    #[\Override]
    public function higherThan(Number $number): bool
    {
        return $this->arcCosine()->number()->higherThan($number);
    }

    #[\Override]
    public function add(Number $number, Number ...$numbers): Number
    {
        return $this->arcCosine()->number()->add($number, ...$numbers);
    }

    #[\Override]
    public function subtract(Number $number, Number ...$numbers): Number
    {
        return $this->arcCosine()->number()->subtract($number, ...$numbers);
    }

    #[\Override]
    public function divideBy(Number $number): Number
    {
        return $this->arcCosine()->number()->divideBy($number);
    }

    #[\Override]
    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return $this->arcCosine()->number()->multiplyBy($number, ...$numbers);
    }

    #[\Override]
    public function roundUp(int $precision = 0): Number
    {
        return $this->arcCosine()->number()->roundUp($precision);
    }

    #[\Override]
    public function roundDown(int $precision = 0): Number
    {
        return $this->arcCosine()->number()->roundDown($precision);
    }

    #[\Override]
    public function roundEven(int $precision = 0): Number
    {
        return $this->arcCosine()->number()->roundEven($precision);
    }

    #[\Override]
    public function roundOdd(int $precision = 0): Number
    {
        return $this->arcCosine()->number()->roundOdd($precision);
    }

    #[\Override]
    public function floor(): Number
    {
        return $this->arcCosine()->number()->floor();
    }

    #[\Override]
    public function ceil(): Number
    {
        return $this->arcCosine()->number()->ceil();
    }

    #[\Override]
    public function modulo(Number $modulus): Number
    {
        return $this->arcCosine()->number()->modulo($modulus);
    }

    #[\Override]
    public function absolute(): Number
    {
        return $this->arcCosine()->number()->absolute();
    }

    #[\Override]
    public function power(Number $power): Number
    {
        return $this->arcCosine()->number()->power($power);
    }

    #[\Override]
    public function squareRoot(): Number
    {
        return $this->arcCosine()->number()->squareRoot();
    }

    #[\Override]
    public function exponential(): Number
    {
        return $this->arcCosine()->number()->exponential();
    }

    #[\Override]
    public function binaryLogarithm(): Number
    {
        return $this->arcCosine()->number()->binaryLogarithm();
    }

    #[\Override]
    public function naturalLogarithm(): Number
    {
        return $this->arcCosine()->number()->naturalLogarithm();
    }

    #[\Override]
    public function commonLogarithm(): Number
    {
        return $this->arcCosine()->number()->commonLogarithm();
    }

    #[\Override]
    public function signum(): Number
    {
        return $this->arcCosine()->number()->signum();
    }

    #[\Override]
    public function collapse(): Number
    {
        return new self($this->number->collapse());
    }

    #[\Override]
    public function toString(): string
    {
        return \sprintf('cos⁻¹(%s)', $this->number->toString());
    }

    private function arcCosine(): Degree
    {
        $radians = Real::of(
            \acos(
                $this->number->value(),
            ),
        );

        return Radian::of($radians)->toDegree();
    }
}
