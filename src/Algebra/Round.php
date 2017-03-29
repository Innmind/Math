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
        return round($this->number->value(), $this->precision, $this->mode);
    }

    public function equals(NumberInterface $number): bool
    {
        return $this->value() == $number->value();
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->value() > $number->value();
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

    public function __toString(): string
    {
        return (string) $this->value();
    }
}
