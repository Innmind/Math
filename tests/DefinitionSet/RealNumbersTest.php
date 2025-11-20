<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\Set,
    Algebra\Integer,
    Algebra\Real,
    Algebra\Value,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class RealNumbersTest extends TestCase
{
    public function testStringCast()
    {
        $this->assertSame('ℝ', Set::realNumbers()->toString());
    }

    public function testContains()
    {
        $set = Set::realNumbers();

        $this->assertTrue($set->contains(Integer::of(1)));
        $this->assertTrue($set->contains(Integer::of(0)));
        $this->assertTrue($set->contains(Integer::of(-1)));
        $this->assertTrue($set->contains(Real::of(0.75)));
        $this->assertTrue($set->contains(Real::of(-0.75)));
        $this->assertTrue($set->contains(Value::pi));
    }

    public function testAccept()
    {
        $set = Set::realNumbers();

        $this->assertNull($set->accept(Integer::of(1)));
        $this->assertNull($set->accept(Integer::of(0)));
        $this->assertNull($set->accept(Integer::of(-1)));
        $this->assertNull($set->accept(Real::of(0.75)));
        $this->assertNull($set->accept(Real::of(-0.75)));
        $this->assertNull($set->accept(Value::pi));
    }

    public function testUnion()
    {
        $union = Set::realNumbers()->union(Set::realNumbers());

        $this->assertSame('ℝ∪ℝ', $union->toString());
    }

    public function testIntersect()
    {
        $intersection = Set::realNumbers()->intersect(Set::realNumbers());

        $this->assertSame('ℝ∩ℝ', $intersection->toString());
    }
}
