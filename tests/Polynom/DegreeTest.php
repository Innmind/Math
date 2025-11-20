<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Polynom;

use Innmind\Math\{
    Polynom\Degree,
    Algebra\Real,
    Algebra\Integer,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class DegreeTest extends TestCase
{
    public function testDegree()
    {
        $d = Degree::of(Integer::of(8), Real::of(2));

        $this->assertSame(8, $d->degree()->value());
        $this->assertSame(2, $d->coeff()->value());
        $this->assertSame(512, $d(Real::of(2))->value());
    }

    public function testStringCast()
    {
        $d = Degree::of(Integer::of(8), Real::of(2));

        $this->assertSame('2x^8', $d->toString());

        $d = Degree::of(Integer::of(1), Real::of(2));

        $this->assertSame('2x', $d->toString());

        $d = Degree::of(Integer::of(8), Integer::of(1)->divideBy(Integer::of(4)));

        $this->assertSame('(1 ÷ 4)x^8', $d->toString());
    }

    public function testPrimitive()
    {
        $d = Degree::of(Integer::of(8), Real::of(2));
        $primitive = $d->primitive();

        $this->assertInstanceOf(Degree::class, $primitive);
        $this->assertNotSame($d, $primitive);
        $this->assertSame('2x^8', $d->toString());
        $this->assertSame('(2 ÷ (8 + 1))x^9', $primitive->toString());
    }

    public function testDerivative()
    {
        $degree = Degree::of(Integer::of(2), Integer::of(2));
        $derivative = $degree->derivative();

        $this->assertInstanceOf(Degree::class, $derivative);
        $this->assertNotSame($degree, $derivative);
        $this->assertSame('2x^2', $degree->toString());
        $this->assertSame('(2 x 2)x', $derivative->toString());
    }
}
