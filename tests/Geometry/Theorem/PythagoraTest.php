<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Gemoetry\Theorem;

use Innmind\Math\{
    Geometry\Theorem\Pythagora,
    Geometry\Segment,
    Algebra\Real,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class PythagoraTest extends TestCase
{
    public function testStringCast()
    {
        $this->assertSame('C²=A²+B²', (new Pythagora)->toString());
    }

    public function testHypotenuse()
    {
        $hypotenuse = Pythagora::hypotenuse(
            Segment::of(Real::of(3)),
            Segment::of(Real::of(2)),
        );

        $this->assertInstanceOf(Segment::class, $hypotenuse);
        $this->assertSame(
            3.605551275463989,
            $hypotenuse->length()->value(),
        );
    }

    public function testAdjacentSide()
    {
        $side = Pythagora::adjacentSide(
            Segment::of(Real::of(5)),
            Segment::of(Real::of(2)),
        );

        $this->assertInstanceOf(Segment::class, $side);
        $this->assertSame(
            4.58257569495584,
            $side->length()->value(),
        );
    }
}
