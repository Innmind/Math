<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet\Set;

use Innmind\Math\{
    DefinitionSet\Set,
    Algebra\Number,
    Exception\OutOfDefinitionSet,
};
use Innmind\Immutable\SideEffect;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
    public function testStringCast()
    {
        $this->assertSame('∅', Set::of()->toString());
        $this->assertSame('{1;2}', Set::of(Number::of(1), Number::of(2))->toString());
    }

    public function testContains()
    {
        $empty = Set::of();

        $this->assertFalse($empty->contains(Number::of(0)));
        $this->assertFalse($empty->contains(Number::of(1)));
        $this->assertFalse($empty->contains(Number::of(-1)));
        $this->assertFalse($empty->contains(Number::of(-0.75)));
        $this->assertFalse($empty->contains(Number::of(0.75)));

        $set = Set::of(Number::of(1), Number::of(2));

        $this->assertTrue($set->contains(Number::of(1)));
        $this->assertTrue($set->contains(Number::of(2)));
        $this->assertFalse($set->contains(Number::of(3)));
        $this->assertFalse($set->contains(Number::of(0)));
    }

    public function testAccept()
    {
        $this->assertInstanceOf(
            SideEffect::class,
            Set::of(Number::of(1))->accept(Number::of(1))->unwrap(),
        );

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('2 ∉ {1}');

        $_ = Set::of(Number::of(1))->accept(Number::of(2))->unwrap();
    }

    public function testUnion()
    {
        $union = Set::of()->union(Set::of());

        $this->assertSame('∅∪∅', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = Set::of()->intersect(Set::of());

        $this->assertSame('∅∩∅', $intersection->toString());
    }
}
