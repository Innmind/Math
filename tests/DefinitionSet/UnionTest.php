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

class UnionTest extends TestCase
{
    public function testStringCast()
    {
        $this->assertSame('∅∪∅', Set::of()->union(Set::of())->toString());
    }

    public function testContains()
    {
        $union = Set::of(
            Number::of(1),
            Number::of(2),
        )->union(
            Set::of(
                Number::of(4),
                Number::of(5),
            ),
        );

        $this->assertTrue($union->contains(Number::of(1)));
        $this->assertTrue($union->contains(Number::of(2)));
        $this->assertTrue($union->contains(Number::of(4)));
        $this->assertTrue($union->contains(Number::of(5)));
        $this->assertFalse($union->contains(Number::of(6)));
        $this->assertFalse($union->contains(Number::of(3)));
        $this->assertFalse($union->contains(Number::of(0)));
    }

    public function testAccept()
    {
        $set = Set::of(
            Number::of(1),
            Number::of(2),
        )->union(
            Set::of(
                Number::of(4),
                Number::of(5),
            ),
        );

        $this->assertInstanceOf(
            SideEffect::class,
            $set->accept(Number::of(1))->unwrap(),
        );

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ {1;2}∪{4;5}');

        $_ = $set->accept(Number::of(0.1))->unwrap();
    }

    public function testUnion()
    {
        $union = Set::of()->union(Set::of())->union(Set::of());

        $this->assertSame('∅∪∅∪∅', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = Set::of()->union(Set::of())->intersect(Set::of());

        $this->assertSame('∅∪∅∩∅', $intersection->toString());
    }
}
