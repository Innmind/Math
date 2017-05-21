<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\ArcTangent,
    Geometry\Trigonometry\Tangent,
    Geometry\Angle\Degree,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class ArcTangentTest extends TestCase
{
    public function testInterface()
    {
        $atan = new ArcTangent(
            new Tangent(new Degree(new Number(42)))
        );

        $this->assertInstanceOf(Degree::class, $atan());
        $this->assertSame('42°', (string) $atan());
    }
}
