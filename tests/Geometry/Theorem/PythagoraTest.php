<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Gemoretry\Theorem;

use Innmind\Math\{
    Geometry\Theorem\Pythagora,
    Geometry\Segment,
    Algebra\Number\Number
};
use PHPUnit\Framework\TestCase;

class PythagoraTest extends TestCase
{
    public function testStringCast()
    {
        $this->assertSame('C²=A²+B²', (string) new Pythagora);
    }

    public function testHypotenuse()
    {
        $hypotenuse = Pythagora::hypotenuse(
            new Segment(new Number(3)),
            new Segment(new Number(2))
        );

        $this->assertInstanceOf(Segment::class, $hypotenuse);
        $this->assertSame(
            3.6055512755,
            $hypotenuse->length()->value()
        );
    }

    public function testAdjacentSide()
    {
        $side = Pythagora::adjacentSide(
            new Segment(new Number(5)),
            new Segment(new Number(2))
        );

        $this->assertInstanceOf(Segment::class, $side);
        $this->assertSame(
            4.582575695,
            $side->length()->value()
        );
    }
}
