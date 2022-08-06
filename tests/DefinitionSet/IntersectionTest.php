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
            new Intersection(
                $this->createMock(SetInterface::class),
                $this->createMock(SetInterface::class),
            ),
        );
    }

    public function testStringCast()
    {
        $this->assertSame('∅∩∅', (new Intersection(new Set, new Set))->toString());
    }

    public function testContains()
    {
        $union = new Intersection(
            new Set(
                new Integer(1),
                new Integer(2),
            ),
            new Set(
                new Integer(4),
                new Integer(5),
            ),
        );

        $this->assertFalse($union->contains(new Number(1)));
        $this->assertFalse($union->contains(new Number(2)));
        $this->assertFalse($union->contains(new Number(4)));
        $this->assertFalse($union->contains(new Number(5)));
        $this->assertFalse($union->contains(new Number(6)));
        $this->assertFalse($union->contains(new Number(3)));
        $this->assertFalse($union->contains(new Number(0)));
    }

    public function testAccept()
    {
        $set = new Intersection(
            new Set(
                new Integer(1),
                new Integer(2),
            ),
            new Set(
                new Integer(2),
                new Integer(5),
            ),
        );

        $this->assertNull($set->accept(new Integer(2)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ {1;2}∩{2;5}');

        $set->accept(new Number(0.1));
    }

    public function testUnion()
    {
        $union = (new Intersection(new Set, new Set))->union(new Set);

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('∅∩∅∪∅', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = (new Intersection(new Set, new Set))->intersect(new Set);

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('∅∩∅∩∅', $intersection->toString());
    }
}
