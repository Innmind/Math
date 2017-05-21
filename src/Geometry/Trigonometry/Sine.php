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
 * sin(angle) = oppositeSide / hypothenuse
 *
 * Where angle is the one between the adjacent side and the hypothenuse
 */
final class Sine implements NumberInterface
{
    private $degree;
    private $sine;

    public function __construct(Degree $degree)
    {
        $this->degree = $degree;
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->sine()->value();
    }

    public function equals(NumberInterface $number): bool
    {
        return $this->sine()->equals($number);
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->sine()->higherThan($number);
    }

    public function add(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->sine()->add($number, ...$numbers);
    }

    public function subtract(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->sine()->subtract($number, ...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return $this->sine()->divideBy($number);
    }

    public function multiplyBy(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->sine()->multiplyBy($number, ...$numbers);
    }

    public function round(int $precision = 0, string $mode = Round::UP): NumberInterface
    {
        return $this->sine()->round($precision, $mode);
    }

    public function floor(): NumberInterface
    {
        return $this->sine()->floor();
    }

    public function ceil(): NumberInterface
    {
        return $this->sine()->ceil();
    }

    public function modulo(NumberInterface $modulus): NumberInterface
    {
        return $this->sine()->modulo($modulus);
    }

    public function absolute(): NumberInterface
    {
        return $this->sine()->absolute();
    }

    public function power(NumberInterface $power): NumberInterface
    {
        return $this->sine()->power($power);
    }

    public function squareRoot(): NumberInterface
    {
        return $this->sine()->squareRoot();
    }

    public function exponential(): NumberInterface
    {
        return $this->sine()->exponential();
    }

    public function binaryLogarithm(): NumberInterface
    {
        return $this->sine()->binaryLogarithm();
    }

    public function naturalLogarithm(): NumberInterface
    {
        return $this->sine()->naturalLogarithm();
    }

    public function commonLogarithm(): NumberInterface
    {
        return $this->sine()->commonLogarithm();
    }

    public function signum(): NumberInterface
    {
        return $this->sine()->signum();
    }

    private function sine(): NumberInterface
    {
        return $this->sine ?? $this->sine = new Number(
            sin(
                $this->degree->toRadian()->number()->value()
            )
        );
    }

    public function __toString(): string
    {
        return sprintf('sin(%s)', $this->degree);
    }
}
