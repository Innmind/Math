<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Figure;

use function Innmind\Math\{
    squareRoot,
    add,
    multiply,
    subtract,
    max as maximum,
    divide,
};
use Innmind\Math\{
    Geometry\Figure,
    Geometry\Segment,
    Algebra\Number,
    Algebra\Value,
};

/**
 * @psalm-immutable
 */
final class Triangle implements Figure
{
    private Number $a;
    private Number $b;
    private Number $c;
    private Segment $height;
    /** @psalm-suppress PropertyNotSetInConstructor */
    private Segment $base;

    private function __construct(
        Segment $a,
        Segment $b,
        Segment $c,
    ) {
        $this->a = $a->length();
        $this->b = $b->length();
        $this->c = $c->length();
        $base = maximum($this->a, $this->b, $this->c);

        switch ($base) {
            case $this->a:
                $this->base = $a;
                break;

            case $this->b:
                $this->base = $b;
                break;

            case $this->c:
                $this->base = $c;
                break;
        }

        $this->height = Segment::of(multiply(
            2,
            divide($this->area(), $base),
        ));
    }

    /**
     * @psalm-pure
     */
    public static function of(
        Segment $a,
        Segment $b,
        Segment $c,
    ): self {
        return new self($a, $b, $c);
    }

    public function perimeter(): Number
    {
        return add($this->a, $this->b, $this->c);
    }

    public function area(): Number
    {
        //Heron's formula
        $p = $this->perimeter()->divideBy(Value::two);

        return squareRoot(
            multiply(
                $p,
                subtract($p, $this->a),
                subtract($p, $this->b),
                subtract($p, $this->c),
            ),
        );
    }

    public function base(): Segment
    {
        return $this->base;
    }

    public function height(): Segment
    {
        return $this->height;
    }

    public function isIsosceles(): bool
    {
        return $this->a->equals($this->b) ||
            $this->a->equals($this->c) ||
            $this->b->equals($this->c);
    }

    public function isEquilateral(): bool
    {
        return $this->a->equals($this->b) &&
            $this->b->equals($this->c);
    }
}
