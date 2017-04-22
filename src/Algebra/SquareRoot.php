<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

final class SquareRoot implements OperationInterface, NumberInterface
{
    private $number;

    public function __construct(NumberInterface $number)
    {
        $this->number = $number;
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->result()->value();
    }

    public function result(): NumberInterface
    {
        return new Number(sqrt($this->number->value()));
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
        return new Division($this, $number);
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
        return new self($this);
    }

    public function __toString(): string
    {
        $number = $this->number instanceof OperationInterface ?
            '('.$this->number.')' : $this->number;

        return '√'.$number;
    }
}
