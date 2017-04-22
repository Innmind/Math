<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\ArcCosine,
    Geometry\Trigonometry\Cosine,
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Algebra\NumberInterface,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class ArcCosineTest extends TestCase
{
    public function testInterface()
    {
        $acos = new ArcCosine(new Degree(new Number(42)));

        $this->assertInstanceOf(NumberInterface::class, $acos());
        $this->assertSame(0.74801822496603, $acos()->value());
        $cos = new Cosine((new Radian($acos()))->toDegree());
        $this->assertSame(
            '42°',
            (string) (new Radian($cos()))->toDegree()
        );
    }
}
