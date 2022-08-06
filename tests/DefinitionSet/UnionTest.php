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
            new Union(
                $this->createMock(SetInterface::class),
                $this->createMock(SetInterface::class),
            ),
        );
    }

    public function testStringCast()
    {
        $this->assertSame('∅∪∅', (new Union(new Set, new Set))->toString());
    }

    public function testContains()
    {
        $union = new Union(
            new Set(
                new Integer(1),
                new Integer(2),
            ),
            new Set(
                new Integer(4),
                new Integer(5),
            ),
        );

        $this->assertTrue($union->contains(new Number(1)));
        $this->assertTrue($union->contains(new Number(2)));
        $this->assertTrue($union->contains(new Number(4)));
        $this->assertTrue($union->contains(new Number(5)));
        $this->assertFalse($union->contains(new Number(6)));
        $this->assertFalse($union->contains(new Number(3)));
        $this->assertFalse($union->contains(new Number(0)));
    }

    public function testAccept()
    {
        $set = new Union(
            new Set(
                new Integer(1),
                new Integer(2),
            ),
            new Set(
                new Integer(4),
                new Integer(5),
            ),
        );

        $this->assertNull($set->accept(new Integer(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ {1;2}∪{4;5}');

        $set->accept(new Number(0.1));
    }

    public function testUnion()
    {
        $union = (new Union(new Set, new Set))->union(new Set);

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('∅∪∅∪∅', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = (new Union(new Set, new Set))->intersect(new Set);

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('∅∪∅∩∅', $intersection->toString());
    }
}
