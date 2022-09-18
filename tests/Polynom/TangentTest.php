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
        $polynom = Polynom::of(
            Integer::of(0),
            Degree::of(
                Integer::of(1),
                Integer::of(2),
            ),
        );
        //t -> f'(2)(x - 2) + f(2)
        $tangent = Tangent::of(
            $polynom,
            $abscissa = Integer::of(2),
        );

        $this->assertSame($polynom, $tangent->polynom());
        $this->assertSame($abscissa, $tangent->abscissa());
        $this->assertInstanceOf(Number::class, $tangent(Integer::of(0)));
        $this->assertSame(
            4.0,
            $tangent(Integer::of(2))->value(),
        );
    }
}
