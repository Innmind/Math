<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

/**
 * @psalm-immutable
 */
final class ComplexNumber
{
    private Number $real;
    private Number $imaginary;

    private function __construct(Number $real, Number $imaginary)
    {
        $this->real = $real;
        $this->imaginary = $imaginary;
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
                    ->multiplyBy(Integer::of(-1)),  // because i^2 == -1
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
            ->power(Value::two)
            ->subtract(
                Integer::of(-1)->multiplyBy(
                    $number->imaginary()->power(Value::two),
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
            Integer::of(-1)->multiplyBy($this->imaginary()),
        );
    }

    public function absolute(): Number
    {
        return $this
            ->real
            ->power(Value::two)
            ->add($this->imaginary->power(Value::two))
            ->squareRoot();
    }

    public function reciprocal(): self
    {
        $divisor = $this
            ->real
            ->power(Value::two)
            ->add($this->imaginary->power(Value::two));

        return new self(
            $this->real->divideBy($divisor),
            Integer::of(-1)->multiplyBy(
                $this->imaginary->divideBy($divisor),
            ),
        );
    }

    public function negation(): self
    {
        return new self(
            Integer::of(-1)->multiplyBy($this->real),
            Integer::of(-1)->multiplyBy($this->imaginary),
        );
    }

    public function squareRoot(): self
    {
        $real = $this
            ->real
            ->add($this->absolute())
            ->divideBy(Value::two)
            ->squareRoot();
        $imaginary = $this->imaginary->signum()->multiplyBy(
            Integer::of(-1)
                ->multiplyBy($this->real)
                ->add($this->absolute())
                ->divideBy(Value::two)
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
        $real = $this->real instanceof Operation ?
            '('.$this->real->toString().')' : $this->real->toString();
        $imaginary = $this->imaginary instanceof Operation ?
            '('.$this->imaginary->toString().')' : $this->imaginary->toString();

        return \sprintf('(%s + %si)', $real, $imaginary);
    }
}
