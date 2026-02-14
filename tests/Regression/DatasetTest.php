<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Regression;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Regression\Dataset,
    Matrix\ColumnVector,
    Matrix\Dimension,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class DatasetTest extends TestCase
{
    public function testInterface()
    {
        $dataset = Dataset::of([
            [1, 2],
            [3, 4],
        ]);

        $this->assertInstanceOf(Dimension::class, $dataset->dimension());
        $this->assertSame('2 x 2', $dataset->dimension()->toString());
        $this->assertInstanceOf(ColumnVector::class, $dataset->abscissas());
        $this->assertInstanceOf(ColumnVector::class, $dataset->ordinates());
        $this->assertEquals(
            numerize(1, 3),
            $dataset->abscissas()->toSequence()->toList(),
        );
        $this->assertEquals(
            numerize(2, 4),
            $dataset->ordinates()->toSequence()->toList(),
        );
    }
}
