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

class NaturalNumbersExceptZeroTest extends TestCase
{
    public function testStringCast()
    {
        $this->assertSame('ℕ*', Set::naturalNumbersExceptZero()->toString());
    }

    public function testContains()
    {
        $set = Set::naturalNumbersExceptZero();

        $this->assertTrue($set->contains(Integer::of(1)));
        $this->assertTrue($set->contains(Integer::of(2)));
        $this->assertFalse($set->contains(Integer::of(0)));
        $this->assertFalse($set->contains(Integer::of(-1)));
        $this->assertFalse($set->contains(Real::of(0.75)));
        $this->assertFalse($set->contains(Real::of(1.75)));
    }

    public function testAccept()
    {
        $set = Set::naturalNumbersExceptZero();

        $this->assertNull($set->accept(Integer::of(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ ℕ*');

        $set->accept(Real::of(0.1));
    }

    public function testUnion()
    {
        $union = Set::naturalNumbersExceptZero()->union(Set::naturalNumbersExceptZero());

        $this->assertSame('ℕ*∪ℕ*', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = Set::naturalNumbersExceptZero()->intersect(Set::naturalNumbersExceptZero());

        $this->assertSame('ℕ*∩ℕ*', $intersection->toString());
    }
}
