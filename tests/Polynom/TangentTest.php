<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Polynom;

use Innmind\Math\{
    Polynom\Tangent,
    Polynom\Polynom,
    Polynom\Degree,
    Algebra\Integer,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class TangentTest extends TestCase
{
    public function testInterface()
    {
        //f -> x^2
        $polynom = new Polynom(
            new Integer(0),
            new Degree(
                new Integer(1),
                new Integer(2),
            ),
        );
        //t -> f'(2)(x - 2) + f(2)
        $tangent = new Tangent(
            $polynom,
            $abscissa = new Integer(2),
        );

        $this->assertSame($polynom, $tangent->polynom());
        $this->assertSame($abscissa, $tangent->abscissa());
        $this->assertInstanceOf(Number::class, $tangent(new Integer(0)));
        $this->assertSame(
            4.0,
            $tangent(new Integer(2))->value(),
        );
    }
}
