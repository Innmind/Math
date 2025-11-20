<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\RealNumbers,
    DefinitionSet\Set,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Real,
    Algebra\Value,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class RealNumbersTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Set::class,
            new RealNumbers,
        );
    }

    public function testStringCast()
    {
        $this->assertSame('ℝ', (new RealNumbers)->toString());
    }

    public function testContains()
    {
        $set = new RealNumbers;

        $this->assertTrue($set->contains(Integer::of(1)));
        $this->assertTrue($set->contains(Integer::of(0)));
        $this->assertTrue($set->contains(Integer::of(-1)));
        $this->assertTrue($set->contains(Real::of(0.75)));
        $this->assertTrue($set->contains(Real::of(-0.75)));
        $this->assertTrue($set->contains(Value::pi));
    }

    public function testAccept()
    {
        $set = new RealNumbers;

        $this->assertNull($set->accept(Integer::of(1)));
        $this->assertNull($set->accept(Integer::of(0)));
        $this->assertNull($set->accept(Integer::of(-1)));
        $this->assertNull($set->accept(Real::of(0.75)));
        $this->assertNull($set->accept(Real::of(-0.75)));
        $this->assertNull($set->accept(Value::pi));
    }

    public function testUnion()
    {
        $union = (new RealNumbers)->union(new RealNumbers);

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('ℝ∪ℝ', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = (new RealNumbers)->intersect(new RealNumbers);

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('ℝ∩ℝ', $intersection->toString());
    }
}
