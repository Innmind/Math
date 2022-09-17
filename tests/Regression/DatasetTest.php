<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Regression;

use function Innmind\Math\numerize;
use Innmind\Math\{
    Regression\Dataset,
    Matrix\RowVector,
    Matrix\ColumnVector,
    Matrix\Dimension,
    Exception\VectorsMustContainsOnlyTwoValues
};
use PHPUnit\Framework\TestCase;

class DatasetTest extends TestCase
{
    public function testInterface()
    {
        $dataset = new Dataset(
            $first = RowVector::of(...numerize(1, 2)),
            $second = RowVector::of(...numerize(3, 4)),
        );

        $this->assertInstanceOf(Dimension::class, $dataset->dimension());
        $this->assertSame('2 x 2', $dataset->dimension()->toString());
        $this->assertSame(
            [[1, 2], [3, 4]],
            $dataset->toList(),
        );
        $this->assertInstanceOf(ColumnVector::class, $dataset->abscissas());
        $this->assertInstanceOf(ColumnVector::class, $dataset->ordinates());
        $this->assertSame(
            [1, 3],
            $dataset->abscissas()->toList(),
        );
        $this->assertSame(
            [2, 4],
            $dataset->ordinates()->toList(),
        );
        $this->assertSame($first, $dataset->row(0));
        $this->assertSame($second, $dataset->row(1));
    }

    public function testThrowWhenNotUsingTwoDimensionalDataset()
    {
        $this->expectException(VectorsMustContainsOnlyTwoValues::class);

        new Dataset(
            RowVector::of(...numerize(1, 2, 3)),
        );
    }

    public function testFromArray()
    {
        $dataset = Dataset::of([
            1,
            2,
            3,
            [3.2, 4],
        ]);

        $this->assertInstanceOf(Dataset::class, $dataset);
        $this->assertSame(
            [
                [0, 1],
                [1, 2],
                [2, 3],
                [3.2, 4],
            ],
            $dataset->toList(),
        );
    }
}
