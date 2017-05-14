<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\OutOfDefinitionSetException;

/**
 * Base 2 logarithm
 */
final class BinaryLogarithm implements OperationInterface, NumberInterface
{
    private $number;
    private $result;

    public function __construct(NumberInterface $number)
    {
        $zero = new Integer(0);

        if ($zero->equals($number) || $zero->higherThan($number)) {
            throw new OutOfDefinitionSetException;
        }

        $this->number = $number;
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
        return new Addition($this, $number, ...$numbers);
    }

    public function subtract(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return new Subtraction($this, $number, ...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return new Division($this, $number);
    }

    public function multiplyBy(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return new Multiplication($this, $number, ...$numbers);
    }

    public function round(int $precision = 0, string $mode = Round::UP): NumberInterface
    {
        return new Round($this, $precision, $mode);
    }

    public function floor(): NumberInterface
    {
        return new Floor($this);
    }

    public function ceil(): NumberInterface
    {
        return new Ceil($this);
    }

    public function modulo(NumberInterface $modulus): NumberInterface
    {
        return new Modulo($this, $modulus);
    }

    public function absolute(): NumberInterface
    {
        return new Absolute($this);
    }

    public function power(NumberInterface $power): NumberInterface
    {
        return new Power($this, $power);
    }

    public function squareRoot(): NumberInterface
    {
        return new SquareRoot($this);
    }

    public function exponential(): NumberInterface
    {
        return new Exponential($this);
    }

    public function binaryLogarithm(): NumberInterface
    {
        return new self($this);
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
        return $this->result ?? $this->result = new Number(
            log($this->number->value(), 2)
        );
    }

    public function __toString(): string
    {
        return sprintf('lb(%s)', $this->number);
    }
}
