<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\Integers,
    DefinitionSet\Set,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Number\Number,
    Exception\OutOfDefinitionSet,
};
use PHPUnit\Framework\TestCase;

class IntegersTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Set::class,
            new Integers,
        );
    }

    public function testStringCast()
    {
        $this->assertSame('ℤ', (new Integers)->toString());
    }

    public function testContains()
    {
        $set = new Integers;

        $this->assertTrue($set->contains(Integer::of(1)));
        $this->assertTrue($set->contains(Integer::of(-1)));
        $this->assertTrue($set->contains(Integer::of(0)));
        $this->assertFalse($set->contains(Number::of(0.75)));
    }

    public function testAccept()
    {
        $this->assertNull((new Integers)->accept(Integer::of(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ ℤ');

        (new Integers)->accept(Number::of(0.1));
    }

    public function testUnion()
    {
        $union = (new Integers)->union(new Integers);

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('ℤ∪ℤ', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = (new Integers)->intersect(new Integers);

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('ℤ∩ℤ', $intersection->toString());
    }
}
