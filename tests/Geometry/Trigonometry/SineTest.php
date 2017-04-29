<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\Sine,
    Geometry\Angle\Degree,
    Algebra\NumberInterface,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class SineTest extends TestCase
{
    public function testInterface()
    {
        $sin = new Sine(new Degree(new Number(42)));

        $this->assertInstanceOf(NumberInterface::class, $sin());
        $this->assertSame(0.66913060635886, $sin()->value());
    }
}
