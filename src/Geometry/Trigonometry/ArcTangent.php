<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Algebra\NumberInterface,
    Algebra\Number,
    Algebra\Round
};

/**
 * Inverse of tangent, such as a===Tangent(ArcTangent(a))
 */
final class ArcTangent implements NumberInterface
{
    private $degree;
    private $arcTangent;

    public function __construct(NumberInterface $number)
    {
        $this->number = $number;
    }

    public function toDegree(): Degree
    {
        return $this->arcTangent();
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->arcTangent()->number()->value();
    }

    public function equals(NumberInterface $number): bool
    {
        return $this->arcTangent()->number()->equals($number);
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->arcTangent()->number()->higherThan($number);
    }

    public function add(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->arcTangent()->number()->add($number, ...$numbers);
    }

    public function subtract(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->arcTangent()->number()->subtract($number, ...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return $this->arcTangent()->number()->divideBy($number);
    }

    public function multiplyBy(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->arcTangent()->number()->multiplyBy($number, ...$numbers);
    }

    public function round(int $precision = 0, string $mode = Round::UP): NumberInterface
    {
        return $this->arcTangent()->number()->round($precision, $mode);
    }

    public function floor(): NumberInterface
    {
        return $this->arcTangent()->number()->floor();
    }

    public function ceil(): NumberInterface
    {
        return $this->arcTangent()->number()->ceil();
    }

    public function modulo(NumberInterface $modulus): NumberInterface
    {
        return $this->arcTangent()->number()->modulo($modulus);
    }

    public function absolute(): NumberInterface
    {
        return $this->arcTangent()->number()->absolute();
    }

    public function power(NumberInterface $power): NumberInterface
    {
        return $this->arcTangent()->number()->power($power);
    }

    public function squareRoot(): NumberInterface
    {
        return $this->arcTangent()->number()->squareRoot();
    }

    public function exponential(): NumberInterface
    {
        return $this->arcTangent()->number()->exponential();
    }

    public function binaryLogarithm(): NumberInterface
    {
        return $this->arcTangent()->number()->binaryLogarithm();
    }

    public function naturalLogarithm(): NumberInterface
    {
        return $this->arcTangent()->number()->naturalLogarithm();
    }

    public function commonLogarithm(): NumberInterface
    {
        return $this->arcTangent()->number()->commonLogarithm();
    }

    public function signum(): NumberInterface
    {
        return $this->arcTangent()->number()->signum();
    }

    private function arcTangent(): Degree
    {
        if ($this->arcTangent) {
            return $this->arcTangent;
        }

        $radians = new Number(
            atan(
                $this->number->value()
            )
        );

        return $this->arcTangent = (new Radian($radians))->toDegree();
    }

    public function __toString(): string
    {
        return sprintf('tan⁻¹(%s)', $this->number);
    }
}
