<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use function Innmind\Math\{
    add,
    multiply,
    divide,
    power,
    subtract,
    squareRoot,
};

/**
 * @psalm-immutable
 */
final class ComplexNumber
{
    private Number $real;
    private Number $imaginary;

    public function __construct(Number $real, Number $imaginary)
    {
        $this->real = $real;
        $this->imaginary = $imaginary;
    }

    public function real(): Number
    {
        return $this->real;
    }

    public function imaginary(): Number
    {
        return $this->imaginary;
    }

    public function add(self $number): self
    {
        return new self(
            $this->real->add($number->real()),
            $this->imaginary->add($number->imaginary()),
        );
    }

    public function subtract(self $number): self
    {
        return new self(
            $this->real->subtract($number->real()),
            $this->imaginary->subtract($number->imaginary()),
        );
    }

    public function multiplyBy(self $number): self
    {
        $real = add(
            multiply($this->real, $number->real()),
            multiply(
                multiply(
                    $this->imaginary,
                    $number->imaginary(),
                ),
                -1, //because i^2 == -1
            ),
        );
        $imaginary = add(
            multiply($this->real, $number->imaginary()),
            multiply($this->imaginary, $number->real()),
        );

        return new self($real, $imaginary);
    }

    public function divideBy(self $number): self
    {
        $dividend = $this->multiplyBy($number->conjugate());
        $divisor = subtract(
            power($number->real(), 2),
            multiply(
                -1,
                power($number->imaginary(), 2),
            ),
        );
        $real = divide($dividend->real(), $divisor);
        $imaginary = divide($dividend->imaginary(), $divisor);

        return new self($real, $imaginary);
    }

    public function conjugate(): self
    {
        return new self(
            $this->real,
            multiply(-1, $this->imaginary()),
        );
    }

    public function absolute(): Number
    {
        return squareRoot(
            add(
                power($this->real, 2),
                power($this->imaginary, 2),
            ),
        );
    }

    public function reciprocal(): self
    {
        $divisor = add(
            power($this->real, 2),
            power($this->imaginary, 2),
        );

        return new self(
            divide($this->real, $divisor),
            multiply(-1, divide($this->imaginary, $divisor)),
        );
    }

    public function negation(): self
    {
        return new self(
            multiply(-1, $this->real),
            multiply(-1, $this->imaginary),
        );
    }

    public function squareRoot(): self
    {
        $real = squareRoot(
            divide(
                add(
                    $this->real,
                    $this->absolute(),
                ),
                2,
            ),
        );
        $imaginary = multiply(
            $this->imaginary->signum(),
            squareRoot(
                divide(
                    add(
                        multiply(-1, $this->real),
                        $this->absolute(),
                    ),
                    2,
                ),
            ),
        );

        return new self($real, $imaginary);
    }

    public function equals(self $number): bool
    {
        return $this->real->equals($number->real()) &&
            $this->imaginary->equals($number->imaginary());
    }

    public function toString(): string
    {
        $real = $this->real instanceof Operation ?
            '('.$this->real->toString().')' : $this->real->toString();
        $imaginary = $this->imaginary instanceof Operation ?
            '('.$this->imaginary->toString().')' : $this->imaginary->toString();

        return \sprintf('(%s + %si)', $real, $imaginary);
    }
}
