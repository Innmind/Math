<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Angle;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Algebra\Real,
};
use PHPUnit\Framework\TestCase;

class DegreeTest extends TestCase
{
    /**
     * @dataProvider degrees
     */
    public function testStringCast($degree, $expected)
    {
        $this->assertSame($expected, (Degree::of(Real::of($degree)))->toString());
    }

    public function testIsRight()
    {
        $this->assertTrue((Degree::of(Real::of(90)))->isRight());
        $this->assertFalse((Degree::of(Real::of(91)))->isRight());
    }

    public function testIsObtuse()
    {
        $this->assertTrue((Degree::of(Real::of(91)))->isObtuse());
        $this->assertFalse((Degree::of(Real::of(89)))->isObtuse());
    }

    public function testIsAcuse()
    {
        $this->assertTrue((Degree::of(Real::of(89)))->isAcuse());
        $this->assertFalse((Degree::of(Real::of(90)))->isAcuse());
    }

    public function testIsFlat()
    {
        $this->assertTrue((Degree::of(Real::of(180)))->isFlat());
        $this->assertFalse((Degree::of(Real::of(181)))->isFlat());
    }

    public function testOpposite()
    {
        $degree = Degree::of(Real::of(270));
        $opposite = $degree->opposite();

        $this->assertNotSame($opposite, $degree);
        $this->assertInstanceOf(Degree::class, $opposite);
        $this->assertSame('270°', $degree->toString());
        $this->assertSame('90°', $opposite->toString());
    }

    /**
     * @dataProvider degrees
     */
    public function testToRadian($degree, $string, $expected)
    {
        $degree = Degree::of(Real::of($degree));
        $radian = $degree->toRadian();

        $this->assertInstanceOf(Radian::class, $radian);
        $this->assertSame($expected, $radian->toString());
    }

    public function degrees(): array
    {
        return [
            [0, '0°', '0 rad'],
            [360, '0°', '0 rad'],
            [42, '42°', '0.73303828583762 rad'],
            [-42, '318°', '5.550147021342 rad'],
        ];
    }
}
