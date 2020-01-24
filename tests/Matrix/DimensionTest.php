<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Matrix;

use Innmind\Math\{
    Matrix\Dimension,
    Algebra\Integer,
    Exception\DimensionMustBePositive
};
use PHPUnit\Framework\TestCase;

class DimensionTest extends TestCase
{
    public function testInterface()
    {
        $dimension = new Dimension(new Integer(2), new Integer(3));

        $this->assertInstanceOf(Integer::class, $dimension->rows());
        $this->assertInstanceOf(Integer::class, $dimension->columns());
        $this->assertSame(2, $dimension->rows()->value());
        $this->assertSame(3, $dimension->columns()->value());
        $this->assertSame('2 x 3', (string) $dimension);
    }

    public function testThrowWhenNegativeRows()
    {
        $this->expectException(DimensionMustBePositive::class);

        new Dimension(new Integer(-1), new Integer(1));
    }

    public function testThrowWhenNegativeColumns()
    {
        $this->expectException(DimensionMustBePositive::class);

        new Dimension(new Integer(1), new Integer(-1));
    }

    public function testEquals()
    {
        $dimension = new Dimension(new Integer(2), new Integer(3));

        $this->assertTrue($dimension->equals($dimension));
        $this->assertTrue($dimension->equals(
            new Dimension(new Integer(2), new Integer(3))
        ));
        $this->assertFalse($dimension->equals(
            new Dimension(new Integer(1), new Integer(3))
        ));
        $this->assertFalse($dimension->equals(
            new Dimension(new Integer(2), new Integer(2))
        ));
        $this->assertFalse($dimension->equals(
            new Dimension(new Integer(1), new Integer(2))
        ));
    }
}
