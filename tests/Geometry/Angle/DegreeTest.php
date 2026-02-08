<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Angle;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Geometry\Angle\Radian,
    Algebra\Number,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class DegreeTest extends TestCase
{
    #[DataProvider('degrees')]
    public function testStringCast($degree, $expected)
    {
        $this->assertSame($expected, Degree::of(Number::of($degree))->toString());
    }

    public function testIsRight()
    {
        $this->assertTrue(Degree::of(Number::of(90))->right());
        $this->assertFalse(Degree::of(Number::of(91))->right());
    }

    public function testIsObtuse()
    {
        $this->assertTrue(Degree::of(Number::of(91))->obtuse());
        $this->assertFalse(Degree::of(Number::of(89))->obtuse());
    }

    public function testIsAcuse()
    {
        $this->assertTrue(Degree::of(Number::of(89))->acuse());
        $this->assertFalse(Degree::of(Number::of(90))->acuse());
    }

    public function testIsFlat()
    {
        $this->assertTrue(Degree::of(Number::of(180))->flat());
        $this->assertFalse(Degree::of(Number::of(181))->flat());
    }

    public function testOpposite()
    {
        $degree = Degree::of(Number::of(270));
        $opposite = $degree->opposite();

        $this->assertNotSame($opposite, $degree);
        $this->assertInstanceOf(Degree::class, $opposite);
        $this->assertSame('270°', $degree->toString());
        $this->assertSame('90°', $opposite->toString());
    }

    #[DataProvider('degrees')]
    public function testToRadian($degree, $string, $expected)
    {
        $degree = Degree::of(Number::of($degree));
        $radian = $degree->toRadian();

        $this->assertInstanceOf(Radian::class, $radian);
        $this->assertSame($expected, $radian->toString());
    }

    public static function degrees(): array
    {
        return [
            [0, '0°', '0 rad'],
            [360, '0°', '0 rad'],
            [42, '42°', '0.73303828583762 rad'],
            [-42, '318°', '5.550147021342 rad'],
        ];
    }
}
