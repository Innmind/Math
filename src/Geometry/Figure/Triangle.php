<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Figure;

use function Innmind\Math\max as maximum;
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

        $this->base = match ($base) {
            $this->a => $a,
            $this->b => $b,
            $this->c => $c,
        };
        $this->height = Segment::of(
            $this
                ->area()
                ->divideBy($base)
                ->multiplyBy(Value::two),
        );
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

    #[\Override]
    public function perimeter(): Number
    {
        return $this
            ->a
            ->add($this->b)
            ->add($this->c);
    }

    #[\Override]
    public function area(): Number
    {
        // Heron's formula
        $p = $this->perimeter()->divideBy(Value::two);

        return $p
            ->multiplyBy($p->subtract($this->a))
            ->multiplyBy($p->subtract($this->b))
            ->multiplyBy($p->subtract($this->c))
            ->squareRoot();
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
