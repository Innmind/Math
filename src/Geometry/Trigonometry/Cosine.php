<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\Number,
    Algebra\Round,
};

/**
 * Given a right-angled rectangle
 *
 * cos(angle) = adjacentSide / hypothenuse
 *
 * Where angle is the one between the adjacent side and the hypothenuse
 */
final class Cosine implements Number
{
    private Degree $degree;
    private ?Number $cosine = null;

    public function __construct(Degree $degree)
    {
        $this->degree = $degree;
    }

    public function value()
    {
        return $this->cosine()->value();
    }

    public function equals(Number $number): bool
    {
        return $this->cosine()->equals($number);
    }

    public function higherThan(Number $number): bool
    {
        return $this->cosine()->higherThan($number);
    }

    public function add(Number $number, Number ...$numbers): Number
    {
        return $this->cosine()->add($number, ...$numbers);
    }

    public function subtract(Number $number, Number ...$numbers): Number
    {
        return $this->cosine()->subtract($number, ...$numbers);
    }

    public function divideBy(Number $number): Number
    {
        return $this->cosine()->divideBy($number);
    }

    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return $this->cosine()->multiplyBy($number, ...$numbers);
    }

    public function roundUp(int $precision = 0): Number
    {
        return $this->cosine()->roundUp($precision);
    }

    public function roundDown(int $precision = 0): Number
    {
        return $this->cosine()->roundDown($precision);
    }

    public function roundEven(int $precision = 0): Number
    {
        return $this->cosine()->roundEven($precision);
    }

    public function roundOdd(int $precision = 0): Number
    {
        return $this->cosine()->roundOdd($precision);
    }

    public function floor(): Number
    {
        return $this->cosine()->floor();
    }

    public function ceil(): Number
    {
        return $this->cosine()->ceil();
    }

    public function modulo(Number $modulus): Number
    {
        return $this->cosine()->modulo($modulus);
    }

    public function absolute(): Number
    {
        return $this->cosine()->absolute();
    }

    public function power(Number $power): Number
    {
        return $this->cosine()->power($power);
    }

    public function squareRoot(): Number
    {
        return $this->cosine()->squareRoot();
    }

    public function exponential(): Number
    {
        return $this->cosine()->exponential();
    }

    public function binaryLogarithm(): Number
    {
        return $this->cosine()->binaryLogarithm();
    }

    public function naturalLogarithm(): Number
    {
        return $this->cosine()->naturalLogarithm();
    }

    public function commonLogarithm(): Number
    {
        return $this->cosine()->commonLogarithm();
    }

    public function signum(): Number
    {
        return $this->cosine()->signum();
    }

    public function toString(): string
    {
        return \sprintf('cos(%s)', $this->degree->toString());
    }

    private function cosine(): Number
    {
        return $this->cosine ??= new Number\Number(
            \cos(
                $this->degree->toRadian()->number()->value(),
            ),
        );
    }
}
