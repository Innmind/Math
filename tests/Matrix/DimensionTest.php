<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Matrix;

use Innmind\Math\Matrix\Dimension;
use PHPUnit\Framework\TestCase;

class DimensionTest extends TestCase
{
    public function testInterface()
    {
        $dimension = new Dimension(2, 3);

        $this->assertSame(2, $dimension->rows());
        $this->assertSame(3, $dimension->columns());
        $this->assertSame('2 x 3', (string) $dimension);
    }

    /**
     * @expectedException Innmind\Math\Exception\NegativeDimensionException
     */
    public function testThrowWhenNegativeRows()
    {
        new Dimension(-1, 1);
    }

    /**
     * @expectedException Innmind\Math\Exception\NegativeDimensionException
     */
    public function testThrowWhenNegativeColumns()
    {
        new Dimension(1, -1);
    }
}
