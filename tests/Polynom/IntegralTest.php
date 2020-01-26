<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Polynom;

use Innmind\Math\{
    Polynom\Integral,
    Polynom\Polynom,
    Algebra\Integer,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class IntegralTest extends TestCase
{
    public function testPolynom()
    {
        $polynom = new Polynom(new Integer(42));
        $integral = new Integral($polynom);

        $this->assertSame($polynom, $integral->polynom());
    }

    public function testStringCast()
    {
        $polynom = (new Polynom)
            ->withDegree(new Integer(1), new Integer(4))
            ->withDegree(new Integer(2), new Integer(-1));
        $integral = new Integral($polynom);

        $this->assertSame(
            '∫(-1x^2 + 4x)dx = [(-1 ÷ (2 + 1))x^3 + (4 ÷ (1 + 1))x^2]',
            $integral->toString()
        );
    }

    public function testInvokation()
    {
        $polynom = (new Polynom)
            ->withDegree(new Integer(1), new Integer(4))
            ->withDegree(new Integer(2), new Integer(-1));
        $integral = new Integral($polynom);

        $area = $integral(new Integer(0), new Integer(4));

        $this->assertInstanceOf(Number::class, $area);
        $this->assertSame(32/3, $area->value());
    }
}
