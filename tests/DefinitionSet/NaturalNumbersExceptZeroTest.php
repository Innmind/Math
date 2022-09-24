<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\NaturalNumbersExceptZero,
    DefinitionSet\Set,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Real,
    Exception\OutOfDefinitionSet,
};
use PHPUnit\Framework\TestCase;

class NaturalNumbersExceptZeroTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Set::class,
            new NaturalNumbersExceptZero,
        );
    }

    public function testStringCast()
    {
        $this->assertSame('ℕ*', (new NaturalNumbersExceptZero)->toString());
    }

    public function testContains()
    {
        $set = new NaturalNumbersExceptZero;

        $this->assertTrue($set->contains(Integer::of(1)));
        $this->assertTrue($set->contains(Integer::of(2)));
        $this->assertFalse($set->contains(Integer::of(0)));
        $this->assertFalse($set->contains(Integer::of(-1)));
        $this->assertFalse($set->contains(Real::of(0.75)));
        $this->assertFalse($set->contains(Real::of(1.75)));
    }

    public function testAccept()
    {
        $set = new NaturalNumbersExceptZero;

        $this->assertNull($set->accept(Integer::of(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ ℕ*');

        $set->accept(Real::of(0.1));
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
