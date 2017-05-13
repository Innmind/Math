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
    public function add(self $number, self ...$numbers): self;
    public function subtract(self $number, self ...$numbers): self;
    public function divideBy(self $number): self;
    public function multiplyBy(self $number, self ...$numbers): self;
    public function round(int $precision = 0, string $mode = Round::UP): self;
    public function floor(): self;
    public function ceil(): self;
    public function modulo(self $modulus): self;
    public function absolute(): self;
    public function power(self $power): self;
    public function squareRoot(): self;
    public function exponential(): self;
    public function __toString(): string;
}
