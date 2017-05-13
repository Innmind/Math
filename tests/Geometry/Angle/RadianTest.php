<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Angle;

use Innmind\Math\{
    Geometry\Angle\Radian,
    Geometry\Angle\Degree,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class RadianTest extends TestCase
{
    /**
     * @dataProvider radians
     */
    public function testStringCast($radian, $expected)
    {
        $this->assertSame($expected, (string) new Radian(new Number($radian)));
    }

    public function testIsRight()
    {
        $this->assertTrue((new Radian(new Number(M_PI_2)))->isRight());
        $this->assertFalse((new Radian(new Number(M_PI)))->isRight());
    }

    public function testIsObtuse()
    {
        $this->assertTrue((new Radian(new Number((2 * pi()) / 3)))->isObtuse());
        $this->assertFalse((new Radian(new Number(pi() / 3)))->isObtuse());
    }

    public function testIsAcuse()
    {
        $this->assertTrue((new Radian(new Number(pi() / 3)))->isAcuse());
        $this->assertFalse((new Radian(new Number(M_PI_2)))->isAcuse());
    }

    public function testIsFlat()
    {
        $this->assertTrue((new Radian(new Number(pi())))->isFlat());
        $this->assertFalse((new Radian(new Number((5 * pi()) / 4)))->isFlat());
    }

    public function testOpposite()
    {
        $radian = new Radian(new Number(pi() / 4));
        $opposite = $radian->opposite();

        $this->assertNotSame($opposite, $radian);
        $this->assertInstanceOf(Radian::class, $opposite);
        $this->assertSame((5 * pi()) / 4, $opposite->number()->value());
    }

    /**
     * @dataProvider radians
     */
    public function testToDegree($radian, $string, $expected)
    {
        $radian = new Radian(new Number($radian));
        $degree = $radian->toDegree();

        $this->assertInstanceOf(Degree::class, $degree);
        $this->assertSame($expected, (string) $degree);
    }

    public function radians(): array
    {
        return [
            [0, '0 rad', '0°'],
            [pi() * 2, '0 rad', '0°'],
            [1, '1 rad', '57.295779513082°'],
            [-(pi() * 3), -pi().' rad', '180°'],
        ];
    }
}
