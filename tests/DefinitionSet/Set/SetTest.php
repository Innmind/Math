<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet\Set;

use Innmind\Math\{
    DefinitionSet\Set\Set,
    DefinitionSet\Set as SetInterface,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Number\Number,
    Exception\OutOfDefinitionSet,
};
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            SetInterface::class,
            Set::of(),
        );
    }

    public function testStringCast()
    {
        $this->assertSame('∅', Set::of()->toString());
        $this->assertSame('{1;2}', Set::of(Integer::of(1), Integer::of(2))->toString());
    }

    public function testContains()
    {
        $empty = Set::of();

        $this->assertFalse($empty->contains(Number::of(0)));
        $this->assertFalse($empty->contains(Number::of(1)));
        $this->assertFalse($empty->contains(Number::of(-1)));
        $this->assertFalse($empty->contains(Number::of(-0.75)));
        $this->assertFalse($empty->contains(Number::of(0.75)));

        $set = Set::of(Integer::of(1), Integer::of(2));

        $this->assertTrue($set->contains(Integer::of(1)));
        $this->assertTrue($set->contains(Integer::of(2)));
        $this->assertFalse($set->contains(Integer::of(3)));
        $this->assertFalse($set->contains(Integer::of(0)));
    }

    public function testAccept()
    {
        $this->assertNull(Set::of(Integer::of(1))->accept(Integer::of(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('2 ∉ {1}');

        Set::of(Integer::of(1))->accept(Integer::of(2));
    }

    public function testUnion()
    {
        $union = Set::of()->union(Set::of());

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('∅∪∅', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = Set::of()->intersect(Set::of());

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('∅∩∅', $intersection->toString());
    }
}
