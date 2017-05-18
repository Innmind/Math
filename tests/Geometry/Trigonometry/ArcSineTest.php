<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\ArcSine,
    Geometry\Trigonometry\Sine,
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Algebra\NumberInterface,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class ArcSineTest extends TestCase
{
    public function testInterface()
    {
        $asin = new ArcSine(new Degree(new Number(42)));

        $this->assertInstanceOf(NumberInterface::class, $asin());
        $this->assertSame(0.8227781018288689, $asin()->value());
        $sin = new Sine((new Radian($asin()))->toDegree());
        $this->assertSame(
            '42°',
            (string) (new Radian($sin()))->toDegree()
        );
    }
}
