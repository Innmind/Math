<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\Set,
    Algebra\Integer,
    Algebra\Real,
    Exception\OutOfDefinitionSet,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class IntegersExceptZeroTest extends TestCase
{
    public function testStringCast()
    {
        $this->assertSame('ℤ*', Set::integersExceptZero()->toString());
    }

    public function testContains()
    {
        $set = Set::integersExceptZero();

        $this->assertTrue($set->contains(Integer::of(1)));
        $this->assertTrue($set->contains(Integer::of(-1)));
        $this->assertFalse($set->contains(Integer::of(0)));
        $this->assertFalse($set->contains(Real::of(0.75)));
    }

    public function testAccept()
    {
        $this->assertNull(Set::integersExceptZero()->accept(Integer::of(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0 ∉ ℤ*');

        Set::integersExceptZero()->accept(Integer::of(0));
    }

    public function testUnion()
    {
        $union = Set::integersExceptZero()->union(Set::integersExceptZero());

        $this->assertSame('ℤ*∪ℤ*', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = Set::integersExceptZero()->intersect(Set::integersExceptZero());

        $this->assertSame('ℤ*∩ℤ*', $intersection->toString());
    }
}
