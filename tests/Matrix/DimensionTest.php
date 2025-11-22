<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Matrix;

use Innmind\Math\Matrix\Dimension;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class DimensionTest extends TestCase
{
    public function testInterface()
    {
        $dimension = Dimension::of(2, 3);

        $this->assertSame(2, $dimension->rows());
        $this->assertSame(3, $dimension->columns());
        $this->assertSame('2 x 3', $dimension->toString());
    }

    public function testEquals()
    {
        $dimension = Dimension::of(2, 3);

        $this->assertTrue($dimension->equals($dimension));
        $this->assertTrue($dimension->equals(
            Dimension::of(2, 3),
        ));
        $this->assertFalse($dimension->equals(
            Dimension::of(1, 3),
        ));
        $this->assertFalse($dimension->equals(
            Dimension::of(2, 2),
        ));
        $this->assertFalse($dimension->equals(
            Dimension::of(1, 2),
        ));
    }
}
