<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\NaturalNumbersExceptZero,
    DefinitionSet\Set,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Number\Number
};
use PHPUnit\Framework\TestCase;

class NaturalNumbersExceptZeroTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Set::class,
            new NaturalNumbersExceptZero
        );
    }

    public function testStringCast()
    {
        $this->assertSame('ℕ*', (new NaturalNumbersExceptZero)->toString());
    }

    public function testContains()
    {
        $set = new NaturalNumbersExceptZero;

        $this->assertTrue($set->contains(new Integer(1)));
        $this->assertTrue($set->contains(new Integer(2)));
        $this->assertFalse($set->contains(new Integer(0)));
        $this->assertFalse($set->contains(new Integer(-1)));
        $this->assertFalse($set->contains(new Number(0.75)));
    }

    public function testUnion()
    {
        $union = (new NaturalNumbersExceptZero)->union(new NaturalNumbersExceptZero);

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('ℕ*∪ℕ*', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = (new NaturalNumbersExceptZero)->intersect(new NaturalNumbersExceptZero);

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('ℕ*∩ℕ*', $intersection->toString());
    }
}
