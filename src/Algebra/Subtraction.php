<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\OperationMustContainAtLeastTwoNumbersException;
use Innmind\Immutable\Sequence;

final class Subtraction implements OperationInterface, NumberInterface
{
    private $values;

    public function __construct(NumberInterface ...$values)
    {
        $this->values = new Sequence(...$values);

        if ($this->values->size() < 2) {
            throw new OperationMustContainAtLeastTwoNumbersException;
        }
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
        return new self($this, $number);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return new Division($this, $number);
    }

    public function multiplyBy(NumberInterface $number): NumberInterface
    {
        return new Multiplication($this, $number);
    }

    public function result(): NumberInterface
    {
        $value = $this
            ->values
            ->drop(1)
            ->reduce(
                $this->values->first()->value(),
                function($carry, NumberInterface $number) {
                    return $carry - $number->value();
                }
            );

        return new Number($value);
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
            ->join(' - ');
    }
}
