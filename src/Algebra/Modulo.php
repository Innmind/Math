<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

final class Modulo implements OperationInterface, NumberInterface
{
    private $number;
    private $modulus;

    public function __construct(
        NumberInterface $number,
        NumberInterface $modulus
    ) {
        $this->number = $number;
        $this->modulus = $modulus;
    }

    public function result(): NumberInterface
    {
        return new Number(
            fmod($this->number->value(), $this->modulus->value())
        );
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

    public function add(NumberInterface $number): NumberInterface
    {
        return new Addition($this, $number);
    }

    public function subtract(NumberInterface $number): NumberInterface
    {
        return new Subtraction($this, $number);
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
        return new self($this, $modulus);
    }

    public function absolute(): NumberInterface
    {
        return new Absolute($this);
    }

    public function __toString(): string
    {
        $number = $this->number instanceof OperationInterface ?
            '('.$this->number.')' : $this->number;
        $modulus = $this->modulus instanceof OperationInterface ?
            '('.$this->modulus.')' : $this->modulus;

        return $number.' % '.$modulus;
    }
}
