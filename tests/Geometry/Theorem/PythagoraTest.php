<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Gemoretry\Theorem;

use Innmind\Math\{
    Geometry\Theorem\Pythagora,
    Algebra\Number
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
        $this->assertSame(
            3.6055512755,
            Pythagora::hypotenuse(
                new Number(3),
                new Number(2)
            )->value()
        );
    }

    public function testAdjacentSide()
    {
        $this->assertSame(
            4.582575695,
            Pythagora::adjacentSide(
                new Number(5),
                new Number(2)
            )->value()
        );
    }
}
