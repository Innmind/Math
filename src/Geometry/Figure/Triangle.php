<?php
declare(strict_types = 1);

namespace Innmind\Math\Geometry\Figure;

use function Innmind\Math\{
    squareRoot,
    add,
    multiply,
    subtract,
    max,
    divide
};
use Innmind\Math\{
    Geometry\FigureInterface,
    Geometry\Segment,
    Geometry\Theorem\AlKashi,
    Algebra\NumberInterface,
    Algebra\Integer
};

final class Triangle implements FigureInterface
{
    private $a;
    private $b;
    private $c;
    private $height;
    private $base;

    public function __construct(
        Segment $a,
        Segment $b,
        Segment $c
    ) {
        $this->a = $a->length();
        $this->b = $b->length();
        $this->c = $c->length();
        $base = max($this->a, $this->b, $this->c);

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

        $this->height = new Segment(multiply(
            2,
            divide($this->area(), $base)
        ));
    }

    public function perimeter(): NumberInterface
    {
        return add($this->a, $this->b, $this->c);
    }

    public function area(): NumberInterface
    {
        //Heron's formula
        $p = $this->perimeter()->divideBy(new Integer(2));

        return squareRoot(
            multiply(
                $p,
                subtract($p, $this->a),
                subtract($p, $this->b),
                subtract($p, $this->c)
            )
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
}