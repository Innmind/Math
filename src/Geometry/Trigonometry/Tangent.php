<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\Number,
    Algebra\Round
};

/**
 * Given a right-angled rectangle
 *
 * tan(angle) = oppositeSide / adjacentSide
 *
 * Where angle is the one between the adjacent side and the hypothenuse
 */
final class Tangent implements Number
{
    private $degree;
    private $tangent;

    public function __construct(Degree $degree)
    {
        $this->degree = $degree;
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->tangent()->value();
    }

    public function equals(Number $number): bool
    {
        return $this->tangent()->equals($number);
    }

    public function higherThan(Number $number): bool
    {
        return $this->tangent()->higherThan($number);
    }

    public function add(Number $number, Number ...$numbers): Number
    {
        return $this->tangent()->add($number, ...$numbers);
    }

    public function subtract(Number $number, Number ...$numbers): Number
    {
        return $this->tangent()->subtract($number, ...$numbers);
    }

    public function divideBy(Number $number): Number
    {
        return $this->tangent()->divideBy($number);
    }

    public function multiplyBy(Number $number, Number ...$numbers): Number
    {
        return $this->tangent()->multiplyBy($number, ...$numbers);
    }

    public function round(int $precision = 0, string $mode = Round::UP): Number
    {
        return $this->tangent()->round($precision, $mode);
    }

    public function floor(): Number
    {
        return $this->tangent()->floor();
    }

    public function ceil(): Number
    {
        return $this->tangent()->ceil();
    }

    public function modulo(Number $modulus): Number
    {
        return $this->tangent()->modulo($modulus);
    }

    public function absolute(): Number
    {
        return $this->tangent()->absolute();
    }

    public function power(Number $power): Number
    {
        return $this->tangent()->power($power);
    }

    public function squareRoot(): Number
    {
        return $this->tangent()->squareRoot();
    }

    public function exponential(): Number
    {
        return $this->tangent()->exponential();
    }

    public function binaryLogarithm(): Number
    {
        return $this->tangent()->binaryLogarithm();
    }

    public function naturalLogarithm(): Number
    {
        return $this->tangent()->naturalLogarithm();
    }

    public function commonLogarithm(): Number
    {
        return $this->tangent()->commonLogarithm();
    }

    public function signum(): Number
    {
        return $this->tangent()->signum();
    }

    private function tangent(): Number
    {
        return $this->tangent ?? $this->tangent = new Number\Number(
            tan(
                $this->degree->toRadian()->number()->value()
            )
        );
    }

    public function toString(): string
    {
        return sprintf('tan(%s)', $this->degree->toString());
    }
}
