<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\Set,
    DefinitionSet\SetInterface,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Number
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
        $this->assertSame('∅', (string) new Set);
        $this->assertSame('{1;2}', (string) new Set(new Integer(1), new Integer(2)));
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
        $this->assertSame('∅∪∅', (string) $union);
    }

    public function testIntersect()
    {
        $intersection = (new Set)->intersect(new Set);

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('∅∩∅', (string) $intersection);
    }
}
