<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\InvalidArgumentException;

final class Round implements NumberInterface
{
    public const UP = 'UP';
    public const DOWN = 'DOWN';
    public const EVEN = 'EVEN';
    public const ODD = 'ODD';

    private $number;
    private $precision;
    private $mode;
    private $value;

    public function __construct(
        NumberInterface $number,
        int $precision = 0,
        string $mode = self::UP
    ) {
        if ($precision < 0) {
            throw new InvalidArgumentException;
        }

        $this->number = $number;
        $this->precision = $precision;
        $this->mode = constant('PHP_ROUND_HALF_'.$mode);
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->value ?? $this->value = round(
            $this->number->value(),
            $this->precision,
            $this->mode
        );
    }

    public function equals(NumberInterface $number): bool
    {
        return $this->value() == $number->value();
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->value() > $number->value();
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
        return new self($this, $precision, $mode);
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

    public function __toString(): string
    {
        return (string) $this->value();
    }
}
