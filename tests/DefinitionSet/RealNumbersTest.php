<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\RealNumbers,
    DefinitionSet\SetInterface,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Number,
    Algebra\Number\Pi
};
use PHPUnit\Framework\TestCase;

class RealNumbersTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            SetInterface::class,
            new RealNumbers
        );
    }

    public function testStringCast()
    {
        $this->assertSame('ℝ', (string) new RealNumbers);
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

    public function testUnion()
    {
        $union = (new RealNumbers)->union(new RealNumbers);

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('ℝ∪ℝ', (string) $union);
    }

    public function testIntersect()
    {
        $intersection = (new RealNumbers)->intersect(new RealNumbers);

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('ℝ∩ℝ', (string) $intersection);
    }
}
