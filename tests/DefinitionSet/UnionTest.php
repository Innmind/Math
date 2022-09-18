<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\Union,
    DefinitionSet\Set as SetInterface,
    DefinitionSet\Set\Set,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Number\Number,
    Exception\OutOfDefinitionSet,
};
use PHPUnit\Framework\TestCase;

class UnionTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            SetInterface::class,
            Union::of(
                $this->createMock(SetInterface::class),
                $this->createMock(SetInterface::class),
            ),
        );
    }

    public function testStringCast()
    {
        $this->assertSame('∅∪∅', (Union::of(Set::of(), Set::of()))->toString());
    }

    public function testContains()
    {
        $union = Union::of(
            Set::of(
                Integer::of(1),
                Integer::of(2),
            ),
            Set::of(
                Integer::of(4),
                Integer::of(5),
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
        $set = Union::of(
            Set::of(
                Integer::of(1),
                Integer::of(2),
            ),
            Set::of(
                Integer::of(4),
                Integer::of(5),
            ),
        );

        $this->assertNull($set->accept(Integer::of(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ {1;2}∪{4;5}');

        $set->accept(Number::of(0.1));
    }

    public function testUnion()
    {
        $union = Union::of(Set::of(), Set::of())->union(Set::of());

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('∅∪∅∪∅', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = Union::of(Set::of(), Set::of())->intersect(Set::of());

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('∅∪∅∩∅', $intersection->toString());
    }
}
