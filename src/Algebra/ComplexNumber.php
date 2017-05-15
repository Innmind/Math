<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use function Innmind\Math\{
    add,
    multiply,
    divide,
    power,
    subtract
};

final class ComplexNumber
{
    private $real;
    private $imaginary;

    public function __construct(
        NumberInterface $real,
        NumberInterface $imaginary
    ) {
        $this->real = $real;
        $this->imaginary = $imaginary;
    }

    public function real(): NumberInterface
    {
        return $this->real;
    }

    public function imaginary(): NumberInterface
    {
        return $this->imaginary;
    }

    public function add(self $number): self
    {
        return new self(
            $this->real->add($number->real()),
            $this->imaginary->add($number->imaginary())
        );
    }

    public function subtract(self $number): self
    {
        return new self(
            $this->real->subtract($number->real()),
            $this->imaginary->subtract($number->imaginary())
        );
    }

    public function multiplyBy(self $number): self
    {
        $real = add(
            multiply($this->real, $number->real()),
            multiply(
                multiply(
                    $this->imaginary,
                    $number->imaginary()
                ),
                -1 //because i^2 == -1
            )
        );
        $imaginary = add(
            multiply($this->real, $number->imaginary()),
            multiply($this->imaginary, $number->real())
        );

        return new self($real, $imaginary);
    }

    public function divideBy(self $number): self
    {
        $conjugate = new self(
            $number->real(),
            multiply(-1, $number->imaginary())
        );
        $dividend = $this->multiplyBy($conjugate);
        $divisor = subtract(
            power($number->real(), 2),
            multiply(
                -1,
                power($number->imaginary(), 2)
            )
        );
        $real = divide($dividend->real(), $divisor);
        $imaginary = divide($dividend->imaginary(), $divisor);

        return new self($real, $imaginary);
    }

    public function __toString(): string
    {
        $real = $this->real instanceof OperationInterface ?
            '('.$this->real.')' : $this->real;
        $imaginary = $this->imaginary instanceof OperationInterface ?
            '('.$this->imaginary.')' : $this->imaginary;

        return sprintf('(%s + %si)', $real, $imaginary);
    }
}
