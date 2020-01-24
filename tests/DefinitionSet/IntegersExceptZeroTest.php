<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\IntegersExceptZero,
    DefinitionSet\Set,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Number\Number
};
use PHPUnit\Framework\TestCase;

class IntegersExceptZeroTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Set::class,
            new IntegersExceptZero
        );
    }

    public function testStringCast()
    {
        $this->assertSame('ℤ*', (new IntegersExceptZero)->toString());
    }

    public function testContains()
    {
        $set = new IntegersExceptZero;

        $this->assertTrue($set->contains(new Integer(1)));
        $this->assertTrue($set->contains(new Integer(-1)));
        $this->assertFalse($set->contains(new Integer(0)));
        $this->assertFalse($set->contains(new Number(0.75)));
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
