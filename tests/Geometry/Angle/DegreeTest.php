<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Angle;

use Innmind\Math\{
    Geometry\Angle\Degree,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class DegreeTest extends TestCase
{
    /**
     * @dataProvider degrees
     */
    public function testStringCast($degree, $expected)
    {
        $this->assertSame($expected, (string) new Degree(new Number($degree)));
    }

    public function testIsRight()
    {
        $this->assertTrue((new Degree(new Number(90)))->isRight());
        $this->assertFalse((new Degree(new Number(91)))->isRight());
    }

    public function testIsObtuse()
    {
        $this->assertTrue((new Degree(new Number(91)))->isObtuse());
        $this->assertFalse((new Degree(new Number(89)))->isObtuse());
    }

    public function testIsAcuse()
    {
        $this->assertTrue((new Degree(new Number(89)))->isAcuse());
        $this->assertFalse((new Degree(new Number(90)))->isAcuse());
    }

    public function testIsFlat()
    {
        $this->assertTrue((new Degree(new Number(180)))->isFlat());
        $this->assertFalse((new Degree(new Number(181)))->isFlat());
    }

    public function testOpposite()
    {
        $degree = new Degree(new Number(270));
        $opposite = $degree->opposite();

        $this->assertNotSame($opposite, $degree);
        $this->assertInstanceOf(Degree::class, $opposite);
        $this->assertSame('270°', (string) $degree);
        $this->assertSame('90°', (string) $opposite);
    }

    public function degrees(): array
    {
        return [
            [0, '0°'],
            [360, '0°'],
            [42, '42°'],
            [-42, '318°'],
        ];
    }
}
