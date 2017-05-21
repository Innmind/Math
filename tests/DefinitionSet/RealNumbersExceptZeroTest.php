<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\RealNumbersExceptZero,
    DefinitionSet\Set,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Number\Number,
    Algebra\Number\Pi
};
use PHPUnit\Framework\TestCase;

class RealNumbersExceptZeroTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Set::class,
            new RealNumbersExceptZero
        );
    }

    public function testStringCast()
    {
        $this->assertSame('ℝ*', (string) new RealNumbersExceptZero);
    }

    public function testContains()
    {
        $set = new RealNumbersExceptZero;

        $this->assertTrue($set->contains(new Integer(1)));
        $this->assertTrue($set->contains(new Integer(-1)));
        $this->assertTrue($set->contains(new Number(0.75)));
        $this->assertTrue($set->contains(new Number(-0.75)));
        $this->assertTrue($set->contains(new Pi));
        $this->assertFalse($set->contains(new Integer(0)));
    }

    public function testUnion()
    {
        $union = (new RealNumbersExceptZero)->union(new RealNumbersExceptZero);

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('ℝ*∪ℝ*', (string) $union);
    }

    public function testIntersect()
    {
        $intersection = (new RealNumbersExceptZero)->intersect(new RealNumbersExceptZero);

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('ℝ*∩ℝ*', (string) $intersection);
    }
}
