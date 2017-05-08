<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\NegativeFactorialException;

final class Integer implements NumberInterface
{
    private $number;

    public function __construct(int $value)
    {
        $this->number = new Number($value);
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->number->value();
    }

    public function equals(NumberInterface $number): bool
    {
        return $this->number->equals($number);
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->number->higherThan($number);
    }

    public function add(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->number->add($number, ...$numbers);
    }

    public function subtract(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->number->subtract($number, ...$numbers);
    }

    public function divideBy(NumberInterface $number): NumberInterface
    {
        return $this->number->divideBy($number);
    }

    public function multiplyBy(
        NumberInterface $number,
        NumberInterface ...$numbers
    ): NumberInterface {
        return $this->number->multiplyBy($number, ...$numbers);
    }

    public function round(int $precision = 0, string $mode = Round::UP): NumberInterface
    {
        return $this->number->round($precision, $mode);
    }

    public function floor(): NumberInterface
    {
        return $this->number->floor();
    }

    public function ceil(): NumberInterface
    {
        return $this->number->ceil();
    }

    public function modulo(NumberInterface $modulus): NumberInterface
    {
        return $this->number->modulo($modulus);
    }

    public function absolute(): NumberInterface
    {
        return $this->number->absolute();
    }

    public function power(NumberInterface $power): NumberInterface
    {
        return $this->number->power($power);
    }

    public function squareRoot(): NumberInterface
    {
        return $this->number->squareRoot();
    }

    public function factorial(): NumberInterface
    {
        if ((new self(0))->higherThan($this)) {
            throw new NegativeFactorialException;
        }

        if ((new self(2))->higherThan($this)) {
            return new Integer(1);
        }

        $factorial = $i = $this->value();

        do {
            $factorial *= --$i;
        } while ($i > 1);

        return new Number($factorial);
    }

    public function __toString(): string
    {
        return (string) $this->number;
    }
}
