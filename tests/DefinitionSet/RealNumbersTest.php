<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\RealNumbers,
    DefinitionSet\Set,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Number\Number,
    Algebra\Number\Pi
};
use PHPUnit\Framework\TestCase;

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

        $this->assertTrue($set->contains(new Integer(1)));
        $this->assertTrue($set->contains(new Integer(0)));
        $this->assertTrue($set->contains(new Integer(-1)));
        $this->assertTrue($set->contains(new Number(0.75)));
        $this->assertTrue($set->contains(new Number(-0.75)));
        $this->assertTrue($set->contains(new Pi));
    }

    public function testAccept()
    {
        $set = new RealNumbers;

        $this->assertNull($set->accept(new Integer(1)));
        $this->assertNull($set->accept(new Integer(0)));
        $this->assertNull($set->accept(new Integer(-1)));
        $this->assertNull($set->accept(new Number(0.75)));
        $this->assertNull($set->accept(new Number(-0.75)));
        $this->assertNull($set->accept(new Pi));
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
