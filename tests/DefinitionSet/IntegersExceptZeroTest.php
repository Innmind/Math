<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\Set,
    Algebra\Number,
    Exception\OutOfDefinitionSet,
};
use Innmind\Immutable\SideEffect;
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

        $this->assertTrue($set->contains(Number::of(1)));
        $this->assertTrue($set->contains(Number::of(-1)));
        $this->assertFalse($set->contains(Number::of(0)));
        $this->assertFalse($set->contains(Number::of(0.75)));
    }

    public function testAccept()
    {
        $this->assertInstanceOf(
            SideEffect::class,
            Set::integersExceptZero()->accept(Number::of(1))->unwrap(),
        );

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0 ∉ ℤ*');

        $_ = Set::integersExceptZero()->accept(Number::of(0))->unwrap();
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
