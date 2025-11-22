<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\Set,
    Algebra\Number,
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

        $this->assertTrue($set->contains(Number::of(1)));
        $this->assertTrue($set->contains(Number::of(2)));
        $this->assertFalse($set->contains(Number::of(0)));
        $this->assertFalse($set->contains(Number::of(-1)));
        $this->assertFalse($set->contains(Number::of(0.75)));
        $this->assertFalse($set->contains(Number::of(1.75)));
    }

    public function testAccept()
    {
        $set = Set::naturalNumbersExceptZero();

        $this->assertNull($set->accept(Number::of(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ ℕ*');

        $set->accept(Number::of(0.1));
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
