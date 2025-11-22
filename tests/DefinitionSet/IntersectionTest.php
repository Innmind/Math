<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\Set,
    Algebra\Number,
    Exception\OutOfDefinitionSet,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class IntersectionTest extends TestCase
{
    public function testContains()
    {
        $intersection = Set::of(
            Number::of(1),
            Number::of(2),
        )->intersect(
            Set::of(
                Number::of(4),
                Number::of(5),
            ),
        );

        $this->assertFalse($intersection->contains(Number::of(1)));
        $this->assertFalse($intersection->contains(Number::of(2)));
        $this->assertFalse($intersection->contains(Number::of(4)));
        $this->assertFalse($intersection->contains(Number::of(5)));
        $this->assertFalse($intersection->contains(Number::of(6)));
        $this->assertFalse($intersection->contains(Number::of(3)));
        $this->assertFalse($intersection->contains(Number::of(0)));
    }

    public function testAccept()
    {
        $set = Set::of(
            Number::of(1),
            Number::of(2),
        )->intersect(
            Set::of(
                Number::of(2),
                Number::of(5),
            ),
        );

        $this->assertNull($set->accept(Number::of(2)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ {1;2}∩{2;5}');

        $set->accept(Number::of(0.1));
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
