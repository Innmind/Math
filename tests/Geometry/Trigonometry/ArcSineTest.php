<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\ArcSine,
    Geometry\Trigonometry\Sine,
    Geometry\Angle\Degree,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class ArcSineTest extends TestCase
{
    public function testInterface()
    {
        $asin = new ArcSine(
            (new Sine(new Degree(new Number(42))))()
        );

        $this->assertInstanceOf(Degree::class, $asin());
        $this->assertSame('42°', (string) $asin());
    }
}
