<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\OperationMustContainAtLeastTwoNumbersException;
use Innmind\Immutable\Sequence;

final class Subtraction
{
    private $values;

    public function __construct(NumberInterface ...$values)
    {
        $this->values = new Sequence(...$values);

        if ($this->values->size() < 2) {
            throw new OperationMustContainAtLeastTwoNumbersException;
        }
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
                return $number->value();
            })
            ->join(' - ');
    }
}
