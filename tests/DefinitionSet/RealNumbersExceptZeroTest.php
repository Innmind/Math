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

class RealNumbersExceptZeroTest extends TestCase
{
    public function testStringCast()
    {
        $this->assertSame('ℝ*', Set::realNumbersExceptZero()->toString());
    }

    public function testContains()
    {
        $set = Set::realNumbersExceptZero();

        $this->assertTrue($set->contains(Number::of(1)));
        $this->assertTrue($set->contains(Number::of(-1)));
        $this->assertTrue($set->contains(Number::of(0.75)));
        $this->assertTrue($set->contains(Number::of(-0.75)));
        $this->assertTrue($set->contains(Number::pi()));
        $this->assertFalse($set->contains(Number::of(0)));
    }

    public function testAccept()
    {
        $set = Set::realNumbersExceptZero();

        $this->assertInstanceOf(
            SideEffect::class,
            $set->accept(Number::of(1))->unwrap(),
        );

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0 ∉ ℝ*');

        $_ = $set->accept(Number::of(0))->unwrap();
    }

    public function testUnion()
    {
        $union = Set::realNumbersExceptZero()->union(Set::realNumbersExceptZero());

        $this->assertSame('ℝ*∪ℝ*', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = Set::realNumbersExceptZero()->intersect(Set::realNumbersExceptZero());

        $this->assertSame('ℝ*∩ℝ*', $intersection->toString());
    }
}
