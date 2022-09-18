<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\Intersection,
    DefinitionSet\Union,
    DefinitionSet\Set as SetInterface,
    DefinitionSet\Set\Set,
    Algebra\Integer,
    Algebra\Number\Number,
    Exception\OutOfDefinitionSet,
};
use PHPUnit\Framework\TestCase;

class IntersectionTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            SetInterface::class,
            Intersection::of(
                $this->createMock(SetInterface::class),
                $this->createMock(SetInterface::class),
            ),
        );
    }

    public function testStringCast()
    {
        $this->assertSame('∅∩∅', (Intersection::of(Set::of(), Set::of()))->toString());
    }

    public function testContains()
    {
        $union = Intersection::of(
            Set::of(
                Integer::of(1),
                Integer::of(2),
            ),
            Set::of(
                Integer::of(4),
                Integer::of(5),
            ),
        );

        $this->assertFalse($union->contains(Number::of(1)));
        $this->assertFalse($union->contains(Number::of(2)));
        $this->assertFalse($union->contains(Number::of(4)));
        $this->assertFalse($union->contains(Number::of(5)));
        $this->assertFalse($union->contains(Number::of(6)));
        $this->assertFalse($union->contains(Number::of(3)));
        $this->assertFalse($union->contains(Number::of(0)));
    }

    public function testAccept()
    {
        $set = Intersection::of(
            Set::of(
                Integer::of(1),
                Integer::of(2),
            ),
            Set::of(
                Integer::of(2),
                Integer::of(5),
            ),
        );

        $this->assertNull($set->accept(Integer::of(2)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ {1;2}∩{2;5}');

        $set->accept(Number::of(0.1));
    }

    public function testUnion()
    {
        $union = Intersection::of(Set::of(), Set::of())->union(Set::of());

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('∅∩∅∪∅', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = Intersection::of(Set::of(), Set::of())->intersect(Set::of());

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('∅∩∅∩∅', $intersection->toString());
    }
}
