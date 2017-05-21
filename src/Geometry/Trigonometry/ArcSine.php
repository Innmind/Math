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
 * Inverse of sine, such as a===Sine(ArcSine(a))
 */
final class ArcSine implements NumberInterface
{
    private $number;
    private $arcSine;

    public function __construct(NumberInterface $number)
    {
        $this->number = $number;
    }

    public function toDegree(): Degree
    {
        return $this->arcSine();
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->arcSine()->number()->value();
    }

    public function equals(NumberInterface $number): bool
    {
        return $this->arcSine()->number()->equals($number);
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->arcSine()->number()->higherThan($number);
    }

    public function add(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->arcSine()->number()->add($number, ...$numbers);
    }

    public function subtract(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->arcSine()->number()->subtract($number, ...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return $this->arcSine()->number()->divideBy($number);
    }

    public function multiplyBy(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->arcSine()->number()->multiplyBy($number, ...$numbers);
    }

    public function round(int $precision = 0, string $mode = Round::UP): NumberInterface
    {
        return $this->arcSine()->number()->round($precision, $mode);
    }

    public function floor(): NumberInterface
    {
        return $this->arcSine()->number()->floor();
    }

    public function ceil(): NumberInterface
    {
        return $this->arcSine()->number()->ceil();
    }

    public function modulo(NumberInterface $modulus): NumberInterface
    {
        return $this->arcSine()->number()->modulo($modulus);
    }

    public function absolute(): NumberInterface
    {
        return $this->arcSine()->number()->absolute();
    }

    public function power(NumberInterface $power): NumberInterface
    {
        return $this->arcSine()->number()->power($power);
    }

    public function squareRoot(): NumberInterface
    {
        return $this->arcSine()->number()->squareRoot();
    }

    public function exponential(): NumberInterface
    {
        return $this->arcSine()->number()->exponential();
    }

    public function binaryLogarithm(): NumberInterface
    {
        return $this->arcSine()->number()->binaryLogarithm();
    }

    public function naturalLogarithm(): NumberInterface
    {
        return $this->arcSine()->number()->naturalLogarithm();
    }

    public function commonLogarithm(): NumberInterface
    {
        return $this->arcSine()->number()->commonLogarithm();
    }

    public function signum(): NumberInterface
    {
        return $this->arcSine()->number()->signum();
    }

    private function arcSine(): Degree
    {
        if ($this->arcSine) {
            return $this->arcSine;
        }

        $radians = new Number(
            asin(
                $this->number->value()
            )
        );

        return $this->arcSine = (new Radian($radians))->toDegree();
    }

    public function __toString(): string
    {
        return sprintf('sin⁻¹(%s)', $this->number);
    }
}
