<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\IntegersExceptZero,
    DefinitionSet\Set,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Real,
    Exception\OutOfDefinitionSet,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class IntegersExceptZeroTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Set::class,
            new IntegersExceptZero,
        );
    }

    public function testStringCast()
    {
        $this->assertSame('ℤ*', (new IntegersExceptZero)->toString());
    }

    public function testContains()
    {
        $set = new IntegersExceptZero;

        $this->assertTrue($set->contains(Integer::of(1)));
        $this->assertTrue($set->contains(Integer::of(-1)));
        $this->assertFalse($set->contains(Integer::of(0)));
        $this->assertFalse($set->contains(Real::of(0.75)));
    }

    public function testAccept()
    {
        $this->assertNull((new IntegersExceptZero)->accept(Integer::of(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0 ∉ ℤ*');

        (new IntegersExceptZero)->accept(Integer::of(0));
    }

    public function testUnion()
    {
        $union = (new IntegersExceptZero)->union(new IntegersExceptZero);

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('ℤ*∪ℤ*', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = (new IntegersExceptZero)->intersect(new IntegersExceptZero);

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('ℤ*∩ℤ*', $intersection->toString());
    }
}
