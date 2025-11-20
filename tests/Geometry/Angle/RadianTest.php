<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Angle;

use Innmind\Math\{
    Geometry\Angle\Radian,
    Geometry\Angle\Degree,
    Algebra\Real,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class RadianTest extends TestCase
{
    #[DataProvider('radians')]
    public function testStringCast($radian, $expected)
    {
        $this->assertSame($expected, (Radian::of(Real::of($radian)))->toString());
    }

    public function testIsRight()
    {
        $this->assertTrue((Radian::of(Real::of(\M_PI_2)))->isRight());
        $this->assertFalse((Radian::of(Real::of(\M_PI)))->isRight());
    }

    public function testIsObtuse()
    {
        $this->assertTrue((Radian::of(Real::of((2 * \pi()) / 3)))->isObtuse());
        $this->assertFalse((Radian::of(Real::of(\pi() / 3)))->isObtuse());
    }

    public function testIsAcuse()
    {
        $this->assertTrue((Radian::of(Real::of(\pi() / 3)))->isAcuse());
        $this->assertFalse((Radian::of(Real::of(\M_PI_2)))->isAcuse());
    }

    public function testIsFlat()
    {
        $this->assertTrue((Radian::of(Real::of(\pi())))->isFlat());
        $this->assertFalse((Radian::of(Real::of((5 * \pi()) / 4)))->isFlat());
    }

    public function testOpposite()
    {
        $radian = Radian::of(Real::of(\pi() / 4));
        $opposite = $radian->opposite();

        $this->assertNotSame($opposite, $radian);
        $this->assertInstanceOf(Radian::class, $opposite);
        $this->assertSame((5 * \pi()) / 4, $opposite->number()->value());
    }

    #[DataProvider('radians')]
    public function testToDegree($radian, $string, $expected)
    {
        $radian = Radian::of(Real::of($radian));
        $degree = $radian->toDegree();

        $this->assertInstanceOf(Degree::class, $degree);
        $this->assertSame($expected, $degree->toString());
    }

    public static function radians(): array
    {
        return [
            [0, '0 rad', '0°'],
            [\pi() * 2, '0 rad', '0°'],
            [1, '1 rad', '57.295779513082°'],
            [-(\pi() * 3), -\pi().' rad', '180°'],
        ];
    }
}
