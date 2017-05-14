<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\NegativeFactorialException;

final class Factorial implements OperationInterface, NumberInterface
{
    private $value;
    private $number;

    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new NegativeFactorialException;
        }

        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->result()->value();
    }

    public function equals(NumberInterface $number): bool
    {
        return $this->result()->equals($number);
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->result()->higherThan($number);
    }

    public function add(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->result()->add($number, ...$numbers);
    }

    public function subtract(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->result()->subtract($number, ...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return $this->result()->divideBy($number);
    }

    public function multiplyBy(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->result()->multiplyBy($number, ...$numbers);
    }

    public function round(int $precision = 0, string $mode = Round::UP): NumberInterface
    {
        return $this->result()->round($precision, $mode);
    }

    public function floor(): NumberInterface
    {
        return $this->result()->floor();
    }

    public function ceil(): NumberInterface
    {
        return $this->result()->ceil();
    }

    public function modulo(NumberInterface $modulus): NumberInterface
    {
        return $this->result()->modulo($modulus);
    }

    public function absolute(): NumberInterface
    {
        return $this->result()->absolute();
    }

    public function power(NumberInterface $power): NumberInterface
    {
        return $this->result()->power($power);
    }

    public function squareRoot(): NumberInterface
    {
        return $this->result()->squareRoot();
    }

    public function exponential(): NumberInterface
    {
        return new Exponential($this);
    }

    public function binaryLogarithm(): NumberInterface
    {
        return new BinaryLogarithm($this);
    }

    public function naturalLogarithm(): NumberInterface
    {
        return new NaturalLogarithm($this);
    }

    public function commonLogarithm(): NumberInterface
    {
        return new CommonLogarithm($this);
    }

    public function result(): NumberInterface
    {
        if ($this->number) {
            return $this->number;
        }

        if ($this->value < 2) {
            return $this->number = new Integer(1);
        }

        $factorial = $i = $this->value;

        do {
            $factorial *= --$i;
        } while ($i > 1);

        return $this->number = Number::wrap($factorial);
    }

    public function __toString(): string
    {
        return $this->value.'!';
    }
}
