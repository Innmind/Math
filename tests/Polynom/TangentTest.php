<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Polynom;

use Innmind\Math\{
    Polynom\Tangent,
    Polynom\Polynom,
    Algebra\Number,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class TangentTest extends TestCase
{
    public function testInterface()
    {
        //f -> x^2
        $polynom = Polynom::zero()->withDegree(
            1,
            Number::of(2),
        );
        //t -> f'(2)(x - 2) + f(2)
        $tangent = Tangent::of(
            $polynom,
            $abscissa = Number::of(2),
        );

        $this->assertSame($polynom, $tangent->polynom());
        $this->assertSame($abscissa, $tangent->abscissa());
        $this->assertInstanceOf(Number::class, $tangent(Number::of(0)));
        $this->assertSame(
            4,
            $tangent(Number::of(2))->value(),
        );
    }
}
