<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet\Set;

use Innmind\Math\{
    DefinitionSet\Set\Set,
    DefinitionSet\Set as SetInterface,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Number\Number
};
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            SetInterface::class,
            new Set
        );
    }

    public function testStringCast()
    {
        $this->assertSame('∅', (new Set)->toString());
        $this->assertSame('{1;2}', (new Set(new Integer(1), new Integer(2)))->toString());
    }

    public function testContains()
    {
        $empty = new Set;

        $this->assertFalse($empty->contains(new Number(0)));
        $this->assertFalse($empty->contains(new Number(1)));
        $this->assertFalse($empty->contains(new Number(-1)));
        $this->assertFalse($empty->contains(new Number(-0.75)));
        $this->assertFalse($empty->contains(new Number(0.75)));

        $set = new Set(new Integer(1), new Integer(2));

        $this->assertTrue($set->contains(new Integer(1)));
        $this->assertTrue($set->contains(new Integer(2)));
        $this->assertFalse($set->contains(new Integer(3)));
        $this->assertFalse($set->contains(new Integer(0)));
    }

    public function testUnion()
    {
        $union = (new Set)->union(new Set);

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('∅∪∅', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = (new Set)->intersect(new Set);

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('∅∩∅', $intersection->toString());
    }
}
