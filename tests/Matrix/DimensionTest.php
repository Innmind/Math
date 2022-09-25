<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Matrix;

use Innmind\Math\{
    Matrix\Dimension,
    Algebra\Integer,
};
use PHPUnit\Framework\TestCase;

class DimensionTest extends TestCase
{
    public function testInterface()
    {
        $dimension = Dimension::of(Integer::of(2), Integer::of(3));

        $this->assertInstanceOf(Integer::class, $dimension->rows());
        $this->assertInstanceOf(Integer::class, $dimension->columns());
        $this->assertSame(2, $dimension->rows()->value());
        $this->assertSame(3, $dimension->columns()->value());
        $this->assertSame('2 x 3', $dimension->toString());
    }

    public function testEquals()
    {
        $dimension = Dimension::of(Integer::of(2), Integer::of(3));

        $this->assertTrue($dimension->equals($dimension));
        $this->assertTrue($dimension->equals(
            Dimension::of(Integer::of(2), Integer::of(3)),
        ));
        $this->assertFalse($dimension->equals(
            Dimension::of(Integer::of(1), Integer::of(3)),
        ));
        $this->assertFalse($dimension->equals(
            Dimension::of(Integer::of(2), Integer::of(2)),
        ));
        $this->assertFalse($dimension->equals(
            Dimension::of(Integer::of(1), Integer::of(2)),
        ));
    }
}
