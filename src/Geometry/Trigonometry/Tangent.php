<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\NumberInterface,
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
final class Tangent implements NumberInterface
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

    public function equals(NumberInterface $number): bool
    {
        return $this->tangent()->equals($number);
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->tangent()->higherThan($number);
    }

    public function add(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->tangent()->add($number, ...$numbers);
    }

    public function subtract(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->tangent()->subtract($number, ...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return $this->tangent()->divideBy($number);
    }

    public function multiplyBy(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->tangent()->multiplyBy($number, ...$numbers);
    }

    public function round(int $precision = 0, string $mode = Round::UP): NumberInterface
    {
        return $this->tangent()->round($precision, $mode);
    }

    public function floor(): NumberInterface
    {
        return $this->tangent()->floor();
    }

    public function ceil(): NumberInterface
    {
        return $this->tangent()->ceil();
    }

    public function modulo(NumberInterface $modulus): NumberInterface
    {
        return $this->tangent()->modulo($modulus);
    }

    public function absolute(): NumberInterface
    {
        return $this->tangent()->absolute();
    }

    public function power(NumberInterface $power): NumberInterface
    {
        return $this->tangent()->power($power);
    }

    public function squareRoot(): NumberInterface
    {
        return $this->tangent()->squareRoot();
    }

    public function exponential(): NumberInterface
    {
        return $this->tangent()->exponential();
    }

    public function binaryLogarithm(): NumberInterface
    {
        return $this->tangent()->binaryLogarithm();
    }

    public function naturalLogarithm(): NumberInterface
    {
        return $this->tangent()->naturalLogarithm();
    }

    public function commonLogarithm(): NumberInterface
    {
        return $this->tangent()->commonLogarithm();
    }

    public function signum(): NumberInterface
    {
        return $this->tangent()->signum();
    }

    private function tangent(): NumberInterface
    {
        return $this->tangent ?? $this->tangent = new Number(
            tan(
                $this->degree->toRadian()->number()->value()
            )
        );
    }

    public function __toString(): string
    {
        return sprintf('tan(%s)', $this->degree);
    }
}
