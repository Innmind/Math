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

class IntersectionTest extends TestCase
{
    public function testContains()
    {
        $intersection = Set::of(
            Integer::of(1),
            Integer::of(2),
        )->intersect(
            Set::of(
                Integer::of(4),
                Integer::of(5),
            ),
        );

        $this->assertFalse($intersection->contains(Real::of(1)));
        $this->assertFalse($intersection->contains(Real::of(2)));
        $this->assertFalse($intersection->contains(Real::of(4)));
        $this->assertFalse($intersection->contains(Real::of(5)));
        $this->assertFalse($intersection->contains(Real::of(6)));
        $this->assertFalse($intersection->contains(Real::of(3)));
        $this->assertFalse($intersection->contains(Real::of(0)));
    }

    public function testAccept()
    {
        $set = Set::of(
            Integer::of(1),
            Integer::of(2),
        )->intersect(
            Set::of(
                Integer::of(2),
                Integer::of(5),
            ),
        );

        $this->assertNull($set->accept(Integer::of(2)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ {1;2}∩{2;5}');

        $set->accept(Real::of(0.1));
    }

    public function testUnion()
    {
        $union = Set::of()->intersect(Set::of())->union(Set::of());

        $this->assertSame('∅∩∅∪∅', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = Set::of()->intersect(Set::of())->intersect(Set::of());

        $this->assertSame('∅∩∅∩∅', $intersection->toString());
    }
}
