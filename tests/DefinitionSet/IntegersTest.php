<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\Set,
    Algebra\Number,
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

        $this->assertTrue($set->contains(Number::of(1)));
        $this->assertTrue($set->contains(Number::of(-1)));
        $this->assertTrue($set->contains(Number::of(0)));
        $this->assertFalse($set->contains(Number::of(0.75)));
    }

    public function testAccept()
    {
        $this->assertNull(Set::integers()->accept(Number::of(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ ℤ');

        Set::integers()->accept(Number::of(0.1));
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
