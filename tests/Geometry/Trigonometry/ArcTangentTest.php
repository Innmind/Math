<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\ArcTangent,
    Geometry\Trigonometry\Tangent,
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Algebra\NumberInterface,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class ArcTangentTest extends TestCase
{
    public function testInterface()
    {
        $atan = new ArcTangent(new Degree(new Number(42)));

        $this->assertInstanceOf(NumberInterface::class, $atan());
        $this->assertSame(0.6325569418587623, $atan()->value());
        $tan = new Tangent((new Radian($atan()))->toDegree());
        $this->assertSame(
            '42°',
            (string) (new Radian($tan()))->toDegree()
        );
    }
}
