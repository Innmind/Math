<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\Integers,
    DefinitionSet\Set,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Number\Number
};
use PHPUnit\Framework\TestCase;

class IntegersTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Set::class,
            new Integers
        );
    }

    public function testStringCast()
    {
        $this->assertSame('ℤ', (string) new Integers);
    }

    public function testContains()
    {
        $set = new Integers;

        $this->assertTrue($set->contains(new Integer(1)));
        $this->assertTrue($set->contains(new Integer(-1)));
        $this->assertTrue($set->contains(new Integer(0)));
        $this->assertFalse($set->contains(new Number(0.75)));
    }

    public function testUnion()
    {
        $union = (new Integers)->union(new Integers);

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('ℤ∪ℤ', (string) $union);
    }

    public function testIntersect()
    {
        $intersection = (new Integers)->intersect(new Integers);

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('ℤ∩ℤ', (string) $intersection);
    }
}
