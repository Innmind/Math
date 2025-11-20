<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\Range,
    DefinitionSet\Set,
    DefinitionSet\Union,
    DefinitionSet\Intersection,
    Algebra\Integer,
    Algebra\Real,
    Exception\OutOfDefinitionSet,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class RangeTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            Set::class,
            Range::inclusive(Integer::of(1), Integer::of(2)),
        );
    }

    public function testStringCast()
    {
        $this->assertSame(
            '[1;2]',
            Range::inclusive(Integer::of(1), Integer::of(2))->toString(),
        );
        $this->assertSame(
            ']1;2[',
            Range::exclusive(Integer::of(1), Integer::of(2))->toString(),
        );
        $this->assertSame(
            '[1;2[',
            Range::inclusive(
                Integer::of(1),
                Integer::of(2),
            )
                ->excludeUpperBound()
                ->toString(),
        );
        $this->assertSame(
            ']1;2]',
            Range::inclusive(
                Integer::of(1),
                Integer::of(2),
            )
                ->excludeLowerBound()
                ->toString(),
        );
    }

    public function testContains()
    {
        $inclusive = Range::inclusive(Integer::of(1), Integer::of(2));

        $this->assertTrue($inclusive->contains(Real::of(1)));
        $this->assertTrue($inclusive->contains(Real::of(1.5)));
        $this->assertTrue($inclusive->contains(Real::of(2)));
        $this->assertFalse($inclusive->contains(Real::of(0)));
        $this->assertFalse($inclusive->contains(Real::of(2.1)));

        $exclusive = Range::exclusive(Integer::of(1), Integer::of(2));

        $this->assertTrue($exclusive->contains(Real::of(1.5)));
        $this->assertFalse($exclusive->contains(Real::of(1)));
        $this->assertFalse($exclusive->contains(Real::of(2)));
        $this->assertFalse($exclusive->contains(Real::of(0)));
        $this->assertFalse($exclusive->contains(Real::of(2.1)));
    }

    public function testAccept()
    {
        $set = Range::inclusive(Integer::of(1), Integer::of(2));

        $this->assertNull($set->accept(Integer::of(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ [1;2]');

        $set->accept(Real::of(0.1));
    }

    public function testUnion()
    {
        $range = Range::inclusive(Integer::of(1), Integer::of(2));
        $union = $range->union($range);

        $this->assertInstanceOf(Union::class, $union);
        $this->assertSame('[1;2]∪[1;2]', $union->toString());
    }

    public function testIntersect()
    {
        $range = Range::inclusive(Integer::of(1), Integer::of(2));
        $intersection = $range->intersect($range);

        $this->assertInstanceOf(Intersection::class, $intersection);
        $this->assertSame('[1;2]∩[1;2]', $intersection->toString());
    }
}
