<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Immutable\Sequence;

final class Addition implements OperationInterface, NumberInterface
{
    private $values;

    public function __construct(
        NumberInterface $first,
        NumberInterface $second,
        NumberInterface ...$values
    ) {
        $this->values = new Sequence($first, $second, ...$values);
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
        return new self($this, $number);
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

    public function sum(): NumberInterface
    {
        return $this->result();
    }

    public function result(): NumberInterface
    {
        $value = $this
            ->values
            ->drop(1)
            ->reduce(
                $this->values->first()->value(),
                function($carry, Number $number) {
                    return $carry + $number->value();
                }
            );

        return new Number($value);
    }

    public function __toString(): string
    {
        return (string) $this
            ->values
            ->map(function(NumberInterface $number): string {
                if ($number instanceof OperationInterface) {
                    return '('.$number.')';
                }

                return (string) $number;
            })
            ->join(' + ');
    }
}
