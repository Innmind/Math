<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\DivisionByZeroError;

final class Division implements OperationInterface, NumberInterface
{
    private $dividend;
    private $divisor;
    private $result;

    public function __construct(
        NumberInterface $dividend,
        NumberInterface $divisor
    ) {
        if ($divisor->value() === 0) {
            throw new DivisionByZeroError;
        }

        $this->dividend = $dividend;
        $this->divisor = $divisor;
    }

    public function dividend(): NumberInterface
    {
        return $this->dividend;
    }

    public function divisor(): NumberInterface
    {
        return $this->divisor;
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

    public function add(NumberInterface ...$numbers): NumberInterface
    {
        return new Addition($this, ...$numbers);
    }

    public function subtract(NumberInterface ...$numbers): NumberInterface
    {
        return new Subtraction($this, ...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return new self($this, $number);
    }

    public function multiplyBy(NumberInterface $number): NumberInterface
    {
        return new Multiplication($this, $number);
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

    public function quotient(): NumberInterface
    {
        return $this->result();
    }

    public function result(): NumberInterface
    {
        return $this->result ?? $this->result = new Number(
            $this->dividend->value() / $this->divisor->value()
        );
    }

    public function __toString(): string
    {
        $dividend = $this->dividend instanceof OperationInterface ?
            '('.$this->dividend.')' : (string) $this->dividend;
        $divisor = $this->divisor instanceof OperationInterface ?
            '('.$this->divisor.')' : (string) $this->divisor;

        return sprintf(
            '%s ÷ %s',
            $dividend,
            $divisor
        );
    }
}
