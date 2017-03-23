<?php
declare(strict_types = 1);

namespace Innmind\Math\Algebra;

use Innmind\Math\Exception\TypeError;

final class Number implements NumberInterface
{
    private $value;

    public function __construct($value)
    {
        if (!is_int($value) && !is_float($value)) {
            throw new TypeError('Number must be an int or a float');
        }

        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->value;
    }

    public function equals(NumberInterface $number): bool
    {
        return $this->value() === $number->value();
    }

    public function higherThan(NumberInterface $number): bool
    {
        return $this->value() > $number->value();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
