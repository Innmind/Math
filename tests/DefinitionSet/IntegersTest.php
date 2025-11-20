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

class IntegersTest extends TestCase
{
    public function testStringCast()
    {
        $this->assertSame('ℤ', Set::integers()->toString());
    }

    public function testContains()
    {
        $set = Set::integers();

        $this->assertTrue($set->contains(Integer::of(1)));
        $this->assertTrue($set->contains(Integer::of(-1)));
        $this->assertTrue($set->contains(Integer::of(0)));
        $this->assertFalse($set->contains(Real::of(0.75)));
    }

    public function testAccept()
    {
        $this->assertNull(Set::integers()->accept(Integer::of(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ ℤ');

        Set::integers()->accept(Real::of(0.1));
    }

    public function testUnion()
    {
        $union = Set::integers()->union(Set::integers());

        $this->assertSame('ℤ∪ℤ', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = Set::integers()->intersect(Set::integers());

        $this->assertSame('ℤ∩ℤ', $intersection->toString());
    }
}
