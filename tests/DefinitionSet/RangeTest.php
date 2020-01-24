<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\Range,
    DefinitionSet\Set,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Number\Number
};
use PHPUnit\Framework\TestCase;

class RangeTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Set::class,
            Range::inclusive(new Integer(1), new Integer(2))
        );
    }

    public function testStringCast()
    {
        $this->assertSame(
            '[1;2]',
            Range::inclusive(new Integer(1), new Integer(2))->toString()
        );
        $this->assertSame(
            ']1;2[',
            Range::exclusive(new Integer(1), new Integer(2))->toString()
        );
        $this->assertSame(
            '[1;2[',
            (new Range(
                Range::INCLUSIVE,
                new Integer(1),
                new Integer(2),
                Range::EXCLUSIVE
            ))->toString()
        );
        $this->assertSame(
            ']1;2]',
            (new Range(
                Range::EXCLUSIVE,
                new Integer(1),
                new Integer(2),
                Range::INCLUSIVE
            ))->toString()
        );
    }

    public function testContains()
    {
        $inclusive = Range::inclusive(new Integer(1), new Integer(2));

        $this->assertTrue($inclusive->contains(new Number(1)));
        $this->assertTrue($inclusive->contains(new Number(1.5)));
        $this->assertTrue($inclusive->contains(new Number(2)));
        $this->assertFalse($inclusive->contains(new Number(0)));
        $this->assertFalse($inclusive->contains(new Number(2.1)));

        $exclusive = Range::exclusive(new Integer(1), new Integer(2));

        $this->assertTrue($exclusive->contains(new Number(1.5)));
        $this->assertFalse($exclusive->contains(new Number(1)));
        $this->assertFalse($exclusive->contains(new Number(2)));
        $this->assertFalse($exclusive->contains(new Number(0)));
        $this->assertFalse($exclusive->contains(new Number(2.1)));
    }

    public function testUnion()
    {
        $range = Range::inclusive(new Integer(1), new Integer(2));
        $union = $range->union($range);

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('[1;2]∪[1;2]', $union->toString());
    }

    public function testIntersect()
    {
        $range = Range::inclusive(new Integer(1), new Integer(2));
        $intersection = $range->intersect($range);

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('[1;2]∩[1;2]', $intersection->toString());
    }
}
