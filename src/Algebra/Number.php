<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 */
interface Number
{
    public function value(): int|float;
    public function equals(self $number): bool;
    public function higherThan(self $number): bool;
    public function add(self $number, self ...$numbers): self;
    public function subtract(self $number, self ...$numbers): self;
    public function divideBy(self $number): self;
    public function multiplyBy(self $number, self ...$numbers): self;
    public function roundUp(int $precision = 0): self;
    public function roundDown(int $precision = 0): self;
    public function roundEven(int $precision = 0): self;
    public function roundOdd(int $precision = 0): self;
    public function floor(): self;
    public function ceil(): self;
    public function modulo(self $modulus): self;
    public function absolute(): self;
    public function power(self $power): self;
    public function squareRoot(): self;
    public function exponential(): self;
    public function binaryLogarithm(): self;
    public function naturalLogarithm(): self;
    public function commonLogarithm(): self;
    public function signum(): self;
    public function toString(): string;
    public function format(): string;

    /**
     * Compute the underlying number like the value() method but it will try to
     * skip some operations to provide the most accurate number
     *
     * For example instead of computing each operation of `sqrt(square(x))` it
     * will directly return `x`
     */
    public function collapse(): self;
}
