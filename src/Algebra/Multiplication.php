<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Immutable\Sequence;

final class Multiplication implements OperationInterface, NumberInterface, \Iterator
{
    private $values;
    private $result;

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
        return new self($this, $number, ...$numbers);
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

    public function product(): NumberInterface
    {
        return $this->result();
    }

    public function result(): NumberInterface
    {
        if ($this->result) {
            return $this->result;
        }

        $value = $this
            ->values
            ->drop(1)
            ->reduce(
                $this->values->first()->value(),
                function($carry, NumberInterface $number) {
                    return $carry * $number->value();
                }
            );

        return $this->result = Number::wrap($value);
    }

    public function __toString(): string
    {
        return (string) $this
            ->values
            ->map(function(NumberInterface $number) {
                if ($number instanceof OperationInterface) {
                    return '('.$number.')';
                }

                return (string) $number;
            })
            ->join(' x ');
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->values->current();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->values->key();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->values->next();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->values->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->values->valid();
    }
}
