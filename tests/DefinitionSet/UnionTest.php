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

class UnionTest extends TestCase
{
    public function testStringCast()
    {
        $this->assertSame('∅∪∅', Set::of()->union(Set::of())->toString());
    }

    public function testContains()
    {
        $union = Set::of(
            Integer::of(1),
            Integer::of(2),
        )->union(
            Set::of(
                Integer::of(4),
                Integer::of(5),
            ),
        );

        $this->assertTrue($union->contains(Real::of(1)));
        $this->assertTrue($union->contains(Real::of(2)));
        $this->assertTrue($union->contains(Real::of(4)));
        $this->assertTrue($union->contains(Real::of(5)));
        $this->assertFalse($union->contains(Real::of(6)));
        $this->assertFalse($union->contains(Real::of(3)));
        $this->assertFalse($union->contains(Real::of(0)));
    }

    public function testAccept()
    {
        $set = Set::of(
            Integer::of(1),
            Integer::of(2),
        )->union(
            Set::of(
                Integer::of(4),
                Integer::of(5),
            ),
        );

        $this->assertNull($set->accept(Integer::of(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ {1;2}∪{4;5}');

        $set->accept(Real::of(0.1));
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
