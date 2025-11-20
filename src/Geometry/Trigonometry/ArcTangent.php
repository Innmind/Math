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
 * Inverse of tangent, such as a===Tangent(ArcTangent(a))
 * @psalm-immutable
 */
final class ArcTangent implements Number
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
        return $this->arcTangent();
    }

    #[\Override]
    public function value(): int|float
    {
        return $this->arcTangent()->number()->value();
    }

    #[\Override]
    public function equals(Number $number): bool
    {
        return $this->arcTangent()->number()->equals($number);
    }

    #[\Override]
    public function higherThan(Number $number): bool
    {
        return $this->arcTangent()->number()->higherThan($number);
    }

    #[\Override]
    public function add(Number $number): Number
    {
        return $this->arcTangent()->number()->add($number);
    }

    #[\Override]
    public function subtract(Number $number): Number
    {
        return $this->arcTangent()->number()->subtract($number);
    }

    #[\Override]
    public function divideBy(Number $number): Number
    {
        return $this->arcTangent()->number()->divideBy($number);
    }

    #[\Override]
    public function multiplyBy(Number $number): Number
    {
        return $this->arcTangent()->number()->multiplyBy($number);
    }

    #[\Override]
    public function roundUp(int $precision = 0): Number
    {
        return $this->arcTangent()->number()->roundUp($precision);
    }

    #[\Override]
    public function roundDown(int $precision = 0): Number
    {
        return $this->arcTangent()->number()->roundDown($precision);
    }

    #[\Override]
    public function roundEven(int $precision = 0): Number
    {
        return $this->arcTangent()->number()->roundEven($precision);
    }

    #[\Override]
    public function roundOdd(int $precision = 0): Number
    {
        return $this->arcTangent()->number()->roundOdd($precision);
    }

    #[\Override]
    public function floor(): Number
    {
        return $this->arcTangent()->number()->floor();
    }

    #[\Override]
    public function ceil(): Number
    {
        return $this->arcTangent()->number()->ceil();
    }

    #[\Override]
    public function modulo(Number $modulus): Number
    {
        return $this->arcTangent()->number()->modulo($modulus);
    }

    #[\Override]
    public function absolute(): Number
    {
        return $this->arcTangent()->number()->absolute();
    }

    #[\Override]
    public function power(Number $power): Number
    {
        return $this->arcTangent()->number()->power($power);
    }

    #[\Override]
    public function squareRoot(): Number
    {
        return $this->arcTangent()->number()->squareRoot();
    }

    #[\Override]
    public function exponential(): Number
    {
        return $this->arcTangent()->number()->exponential();
    }

    #[\Override]
    public function binaryLogarithm(): Number
    {
        return $this->arcTangent()->number()->binaryLogarithm();
    }

    #[\Override]
    public function naturalLogarithm(): Number
    {
        return $this->arcTangent()->number()->naturalLogarithm();
    }

    #[\Override]
    public function commonLogarithm(): Number
    {
        return $this->arcTangent()->number()->commonLogarithm();
    }

    #[\Override]
    public function signum(): Number
    {
        return $this->arcTangent()->number()->signum();
    }

    #[\Override]
    public function collapse(): Number
    {
        return new self($this->number->collapse());
    }

    #[\Override]
    public function toString(): string
    {
        return \sprintf('tan⁻¹(%s)', $this->number->toString());
    }

    #[\Override]
    public function format(): string
    {
        return $this->toString();
    }

    private function arcTangent(): Degree
    {
        $radians = Real::of(
            \atan(
                $this->number->value(),
            ),
        );

        return Radian::of($radians)->toDegree();
    }
}
