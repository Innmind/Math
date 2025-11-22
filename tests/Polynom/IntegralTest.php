<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Polynom;

use Innmind\Math\{
    Polynom\Integral,
    Polynom\Polynom,
    Algebra\Number,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class IntegralTest extends TestCase
{
    public function testPolynom()
    {
        $polynom = Polynom::interceptAt(Number::of(42));
        $integral = Integral::of($polynom);

        $this->assertSame($polynom, $integral->polynom());
    }

    public function testStringCast()
    {
        $polynom = Polynom::zero()
            ->withDegree(1, Number::of(4))
            ->withDegree(2, Number::of(-1));
        $integral = Integral::of($polynom);

        $this->assertSame(
            '∫(-1x^2 + 4x)dx = [(-1 ÷ (2 + 1))x^3 + (4 ÷ (1 + 1))x^2]',
            $integral->toString(),
        );
    }

    public function testInvokation()
    {
        $polynom = Polynom::zero()
            ->withDegree(1, Number::of(4))
            ->withDegree(2, Number::of(-1));
        $integral = Integral::of($polynom);

        $area = $integral(Number::of(0), Number::of(4));

        $this->assertInstanceOf(Number::class, $area);
        // 32/3
        $this->assertSame(10.666666666666668, $area->value());
    }
}
