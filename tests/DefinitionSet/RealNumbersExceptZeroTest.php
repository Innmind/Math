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
    Algebra\Number\Pi,
    Exception\OutOfDefinitionSet,
};
use PHPUnit\Framework\TestCase;

class RealNumbersExceptZeroTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Set::class,
            new RealNumbersExceptZero,
        );
    }

    public function testStringCast()
    {
        $this->assertSame('ℝ*', (new RealNumbersExceptZero)->toString());
    }

    public function testContains()
    {
        $set = new RealNumbersExceptZero;

        $this->assertTrue($set->contains(Integer::of(1)));
        $this->assertTrue($set->contains(Integer::of(-1)));
        $this->assertTrue($set->contains(Number::of(0.75)));
        $this->assertTrue($set->contains(Number::of(-0.75)));
        $this->assertTrue($set->contains(new Pi));
        $this->assertFalse($set->contains(Integer::of(0)));
    }

    public function testAccept()
    {
        $set = new RealNumbersExceptZero;

        $this->assertNull($set->accept(Integer::of(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0 ∉ ℝ*');

        $set->accept(Number::of(0));
    }

    public function testUnion()
    {
        $union = (new RealNumbersExceptZero)->union(new RealNumbersExceptZero);

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('ℝ*∪ℝ*', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = (new RealNumbersExceptZero)->intersect(new RealNumbersExceptZero);

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('ℝ*∩ℝ*', $intersection->toString());
    }
}
