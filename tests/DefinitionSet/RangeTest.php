<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\DefinitionSet;

use Innmind\Math\{
    DefinitionSet\Set,
    Algebra\Number,
    Exception\OutOfDefinitionSet,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class RangeTest extends TestCase
{
    public function testStringCast()
    {
        $this->assertSame(
            '[1;2]',
            Set::inclusiveRange(Number::of(1), Number::of(2))->toString(),
        );
        $this->assertSame(
            ']1;2[',
            Set::exclusiveRange(Number::of(1), Number::of(2))->toString(),
        );
    }

    public function testContains()
    {
        $inclusive = Set::inclusiveRange(Number::of(1), Number::of(2));

        $this->assertTrue($inclusive->contains(Number::of(1)));
        $this->assertTrue($inclusive->contains(Number::of(1.5)));
        $this->assertTrue($inclusive->contains(Number::of(2)));
        $this->assertFalse($inclusive->contains(Number::of(0)));
        $this->assertFalse($inclusive->contains(Number::of(2.1)));

        $exclusive = Set::exclusiveRange(Number::of(1), Number::of(2));

        $this->assertTrue($exclusive->contains(Number::of(1.5)));
        $this->assertFalse($exclusive->contains(Number::of(1)));
        $this->assertFalse($exclusive->contains(Number::of(2)));
        $this->assertFalse($exclusive->contains(Number::of(0)));
        $this->assertFalse($exclusive->contains(Number::of(2.1)));
    }

    public function testAccept()
    {
        $set = Set::inclusiveRange(Number::of(1), Number::of(2));

        $this->assertNull($set->accept(Number::of(1)));

        $this->expectException(OutOfDefinitionSet::class);
        $this->expectExceptionMessage('0.1 ∉ [1;2]');

        $set->accept(Number::of(0.1));
    }

    public function testUnion()
    {
        $range = Set::inclusiveRange(Number::of(1), Number::of(2));
        $union = $range->union($range);

        $this->assertSame('[1;2]∪[1;2]', $union->toString());
    }

    public function testIntersect()
    {
        $range = Set::inclusiveRange(Number::of(1), Number::of(2));
        $intersection = $range->intersect($range);

        $this->assertSame('[1;2]∩[1;2]', $intersection->toString());
    }
}
