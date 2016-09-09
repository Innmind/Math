<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Matrix;

use Innmind\Math\Matrix\Dimension;

class DimensionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $dimension = new Dimension(2, 3);

        $this->assertSame(2, $dimension->rows());
        $this->assertSame(3, $dimension->columns());
        $this->assertSame('2 x 3', (string) $dimension);
    }
}
