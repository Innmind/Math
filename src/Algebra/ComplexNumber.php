<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 */
final class ComplexNumber
{
    private function __construct(
        private Number $real,
        private Number $imaginary,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(Number $real, Number $imaginary): self
    {
        return new self($real, $imaginary);
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
        $real = $this
            ->real
            ->multiplyBy($number->real())
            ->add(
                $this
                    ->imaginary
                    ->multiplyBy($number->imaginary())
                    ->multiplyBy(Number::of(-1)),  // because i^2 == -1
            );
        $imaginary = $this
            ->real
            ->multiplyBy($number->imaginary())
            ->add($this->imaginary->multiplyBy($number->real()));

        return new self($real, $imaginary);
    }

    public function divideBy(self $number): self
    {
        $dividend = $this->multiplyBy($number->conjugate());
        $divisor = $number
            ->real()
            ->power(Number::two())
            ->subtract(
                Number::of(-1)->multiplyBy(
                    $number->imaginary()->power(Number::two()),
                ),
            );
        $real = $dividend->real()->divideBy($divisor);
        $imaginary = $dividend->imaginary()->divideBy($divisor);

        return new self($real, $imaginary);
    }

    public function conjugate(): self
    {
        return new self(
            $this->real,
            Number::of(-1)->multiplyBy($this->imaginary()),
        );
    }

    public function absolute(): Number
    {
        return $this
            ->real
            ->power(Number::two())
            ->add($this->imaginary->power(Number::two()))
            ->squareRoot();
    }

    public function reciprocal(): self
    {
        $divisor = $this
            ->real
            ->power(Number::two())
            ->add($this->imaginary->power(Number::two()));

        return new self(
            $this->real->divideBy($divisor),
            Number::of(-1)->multiplyBy(
                $this->imaginary->divideBy($divisor),
            ),
        );
    }

    public function negation(): self
    {
        return new self(
            Number::of(-1)->multiplyBy($this->real),
            Number::of(-1)->multiplyBy($this->imaginary),
        );
    }

    public function squareRoot(): self
    {
        $real = $this
            ->real
            ->add($this->absolute())
            ->divideBy(Number::two())
            ->squareRoot();
        $imaginary = $this->imaginary->signum()->multiplyBy(
            Number::of(-1)
                ->multiplyBy($this->real)
                ->add($this->absolute())
                ->divideBy(Number::two())
                ->squareRoot(),
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
        $real = $this->real->format();
        $imaginary = $this->imaginary->format();

        return \sprintf('(%s + %si)', $real, $imaginary);
    }
}
