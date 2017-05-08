<?php
declare(strict_types = 1);

namespace Innmind\Math\Polynom;

use function Innmind\Math\{
    add,
    multiply
};
use Innmind\Math\Algebra\{
    NumberInterface,
    Number
};

final class Tangent
{
    private $polynom;
    private $derivative;
    private $abscissa;
    private $intercept;

    public function __construct(
        Polynom $polynom,
        NumberInterface $abscissa,
        NumberInterface $limit = null
    ) {
        $this->polynom = $polynom;
        $this->derivative = $polynom->derivative($abscissa, $limit);
        $this->abscissa = $abscissa;
        $this->intercept = $polynom($abscissa);
    }

    public function polynom(): Polynom
    {
        return $this->polynom;
    }

    public function abscissa(): NumberInterface
    {
        return $this->abscissa;
    }

    public function __invoke(NumberInterface $x): NumberInterface
    {
        return add(
            multiply(
                $this->derivative,
                $x->subtract($this->abscissa)
            ),
            $this->intercept
        );
    }

    public static function limit(): NumberInterface
    {
        return new Number(0.000000000001);
    }
}
