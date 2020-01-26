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
            $first = new RowVector(...numerize(1, 2)),
            $second = new RowVector(...numerize(3, 4)),
        );

        $this->assertInstanceOf(Dimension::class, $dataset->dimension());
        $this->assertSame('2 x 2', $dataset->dimension()->toString());
        $this->assertSame(
            [[1, 2], [3, 4]],
            $dataset->toArray()
        );
        $this->assertInstanceOf(ColumnVector::class, $dataset->abscissas());
        $this->assertInstanceOf(ColumnVector::class, $dataset->ordinates());
        $this->assertSame(
            [1, 3],
            $dataset->abscissas()->toArray()
        );
        $this->assertSame(
            [2, 4],
            $dataset->ordinates()->toArray()
        );
        $this->assertSame($first, $dataset->row(0));
        $this->assertSame($second, $dataset->row(1));
    }

    public function testThrowWhenNotUsingTwoDimensionalDataset()
    {
        $this->expectException(VectorsMustContainsOnlyTwoValues::class);

        new Dataset(
            new RowVector(...numerize(1, 2, 3))
        );
    }

    public function testFromArray()
    {
        $dataset = Dataset::fromArray([
            1,
            2,
            3,
            [3.2, 4]
        ]);

        $this->assertInstanceOf(Dataset::class, $dataset);
        $this->assertSame(
            [
                [0, 1],
                [1, 2],
                [2, 3],
                [3.2, 4],
            ],
            $dataset->toArray()
        );
    }
}
