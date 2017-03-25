<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

interface NumberInterface
{
    /**
     * @return int|float
     */
    public function value();
    public function equals(self $number): bool;
    public function higherThan(self $number): bool;
    public function add(NumberInterface $number): NumberInterface;
    public function subtract(NumberInterface $number): NumberInterface;
    public function divideBy(NumberInterface $number): NumberInterface;
    public function multiplyBy(NumberInterface $number): NumberInterface;
    public function round(int $precision = 0, string $mode = Round::UP): NumberInterface;
    public function floor(): NumberInterface;
    public function __toString(): string;
}
