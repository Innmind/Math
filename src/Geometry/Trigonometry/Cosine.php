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
 * cos(angle) = adjacentSide / hypothenuse
 *
 * Where angle is the one between the adjacent side and the hypothenuse
 */
final class Cosine implements NumberInterface
{
    private $degree;
    private $cosine;

    public function __construct(Degree $degree)
    {
        $this->degree = $degree;
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->cosine()->value();
    }

    public function equals(NumberInterface $number): bool
    {
        return $this->cosine()->equals($number);
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->cosine()->higherThan($number);
    }

    public function add(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->cosine()->add($number, ...$numbers);
    }

    public function subtract(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->cosine()->subtract($number, ...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return $this->cosine()->divideBy($number);
    }

    public function multiplyBy(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->cosine()->multiplyBy($number, ...$numbers);
    }

    public function round(int $precision = 0, string $mode = Round::UP): NumberInterface
    {
        return $this->cosine()->round($precision, $mode);
    }

    public function floor(): NumberInterface
    {
        return $this->cosine()->floor();
    }

    public function ceil(): NumberInterface
    {
        return $this->cosine()->ceil();
    }

    public function modulo(NumberInterface $modulus): NumberInterface
    {
        return $this->cosine()->modulo($modulus);
    }

    public function absolute(): NumberInterface
    {
        return $this->cosine()->absolute();
    }

    public function power(NumberInterface $power): NumberInterface
    {
        return $this->cosine()->power($power);
    }

    public function squareRoot(): NumberInterface
    {
        return $this->cosine()->squareRoot();
    }

    public function exponential(): NumberInterface
    {
        return $this->cosine()->exponential();
    }

    public function binaryLogarithm(): NumberInterface
    {
        return $this->cosine()->binaryLogarithm();
    }

    public function naturalLogarithm(): NumberInterface
    {
        return $this->cosine()->naturalLogarithm();
    }

    public function commonLogarithm(): NumberInterface
    {
        return $this->cosine()->commonLogarithm();
    }

    public function signum(): NumberInterface
    {
        return $this->cosine()->signum();
    }

    private function cosine(): NumberInterface
    {
        return $this->cosine ?? $this->cosine = new Number(
            cos(
                $this->degree->toRadian()->number()->value()
            )
        );
    }

    public function __toString(): string
    {
        return sprintf('cos(%s)', $this->degree);
    }
}
