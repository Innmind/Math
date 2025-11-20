<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\NaturalNumbers,
    DefinitionSet\Set,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Real,
    Exception\OutOfDefinitionSet,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class NaturalNumbersTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Set::class,
            new NaturalNumbers,
        );
    }

    public function testStringCast()
    {
        $this->assertSame('ℕ', (new NaturalNumbers)->toString());
    }

    public function testContains()
    {
        $set = new NaturalNumbers;

        $this->assertTrue($set->contains(Integer::of(1)));
        $this->assertTrue($set->contains(Integer::of(0)));
        $this->assertFalse($set->contains(Integer::of(-1)));
        $this->assertFalse($set->contains(Real::of(0.75)));
    }

    public function testAccept()
    {
        $set = new NaturalNumbers;

        $this->assertNull($set->accept(Integer::of(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ ℕ');

        $set->accept(Real::of(0.1));
    }

    public function testUnion()
    {
        $union = (new NaturalNumbers)->union(new NaturalNumbers);

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('ℕ∪ℕ', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = (new NaturalNumbers)->intersect(new NaturalNumbers);

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('ℕ∩ℕ', $intersection->toString());
    }
}
