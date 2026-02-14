<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\Set,
    Algebra\Number,
};
use Innmind\Immutable\SideEffect;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class RealNumbersTest extends TestCase
{
    public function testStringCast()
    {
        $this->assertSame('ℝ', Set::realNumbers()->toString());
    }

    public function testContains()
    {
        $set = Set::realNumbers();

        $this->assertTrue($set->contains(Number::of(1)));
        $this->assertTrue($set->contains(Number::of(0)));
        $this->assertTrue($set->contains(Number::of(-1)));
        $this->assertTrue($set->contains(Number::of(0.75)));
        $this->assertTrue($set->contains(Number::of(-0.75)));
        $this->assertTrue($set->contains(Number::pi()));
    }

    public function testAccept()
    {
        $set = Set::realNumbers();

        $this->assertInstanceOf(SideEffect::class, $set->accept(Number::of(1))->unwrap());
        $this->assertInstanceOf(SideEffect::class, $set->accept(Number::of(0))->unwrap());
        $this->assertInstanceOf(SideEffect::class, $set->accept(Number::of(-1))->unwrap());
        $this->assertInstanceOf(SideEffect::class, $set->accept(Number::of(0.75))->unwrap());
        $this->assertInstanceOf(SideEffect::class, $set->accept(Number::of(-0.75))->unwrap());
        $this->assertInstanceOf(SideEffect::class, $set->accept(Number::pi())->unwrap());
    }

    public function testUnion()
    {
        $union = Set::realNumbers()->union(Set::realNumbers());

        $this->assertSame('ℝ∪ℝ', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = Set::realNumbers()->intersect(Set::realNumbers());

        $this->assertSame('ℝ∩ℝ', $intersection->toString());
    }
}
