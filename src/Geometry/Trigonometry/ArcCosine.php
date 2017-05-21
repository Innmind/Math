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
 * Inverse of cosine, such as a===Cosine(ArcCosine(a))
 */
final class ArcCosine implements NumberInterface
{
    private $number;
    private $arcCosine;

    public function __construct(NumberInterface $number)
    {
        $this->number = $number;
    }

    public function toDegree(): Degree
    {
        return $this->arcCosine();
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->arcCosine()->number()->value();
    }

    public function equals(NumberInterface $number): bool
    {
        return $this->arcCosine()->number()->equals($number);
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->arcCosine()->number()->higherThan($number);
    }

    public function add(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->arcCosine()->number()->add($number, ...$numbers);
    }

    public function subtract(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->arcCosine()->number()->subtract($number, ...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return $this->arcCosine()->number()->divideBy($number);
    }

    public function multiplyBy(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->arcCosine()->number()->multiplyBy($number, ...$numbers);
    }

    public function round(int $precision = 0, string $mode = Round::UP): NumberInterface
    {
        return $this->arcCosine()->number()->round($precision, $mode);
    }

    public function floor(): NumberInterface
    {
        return $this->arcCosine()->number()->floor();
    }

    public function ceil(): NumberInterface
    {
        return $this->arcCosine()->number()->ceil();
    }

    public function modulo(NumberInterface $modulus): NumberInterface
    {
        return $this->arcCosine()->number()->modulo($modulus);
    }

    public function absolute(): NumberInterface
    {
        return $this->arcCosine()->number()->absolute();
    }

    public function power(NumberInterface $power): NumberInterface
    {
        return $this->arcCosine()->number()->power($power);
    }

    public function squareRoot(): NumberInterface
    {
        return $this->arcCosine()->number()->squareRoot();
    }

    public function exponential(): NumberInterface
    {
        return $this->arcCosine()->number()->exponential();
    }

    public function binaryLogarithm(): NumberInterface
    {
        return $this->arcCosine()->number()->binaryLogarithm();
    }

    public function naturalLogarithm(): NumberInterface
    {
        return $this->arcCosine()->number()->naturalLogarithm();
    }

    public function commonLogarithm(): NumberInterface
    {
        return $this->arcCosine()->number()->commonLogarithm();
    }

    public function signum(): NumberInterface
    {
        return $this->arcCosine()->number()->signum();
    }

    private function arcCosine(): Degree
    {
        if ($this->arcCosine) {
            return $this->arcCosine;
        }

        $radians = new Number(
            acos(
                $this->number->value()
            )
        );

        return $this->arcCosine = (new Radian($radians))->toDegree();
    }

    public function __toString(): string
    {
        return sprintf('cos⁻¹(%s)', $this->number);
    }
}
