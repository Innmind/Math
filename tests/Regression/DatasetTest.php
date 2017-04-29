<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Regression;

use Innmind\Math\{
    Regression\Dataset,
    Matrix\RowVector,
    Matrix\ColumnVector,
    Matrix\Dimension
};
use PHPUnit\Framework\TestCase;

class DatasetTest extends TestCase
{
    public function testInterface()
    {
        $dataset = new Dataset(
            new RowVector(1, 2),
            new RowVector(2, 3)
        );

        $this->assertInstanceOf(\Iterator::class, $dataset);
        $this->assertInstanceOf(Dimension::class, $dataset->dimension());
        $this->assertSame('2 x 2', (string) $dataset->dimension());
        $this->assertSame(
            [[1.0, 2.0], [2.0, 3.0]],
            $dataset->toArray()
        );
        $this->assertInstanceOf(ColumnVector::class, $dataset->abscissas());
        $this->assertInstanceOf(ColumnVector::class, $dataset->ordinates());
        $this->assertSame(
            [1.0, 2.0],
            $dataset->abscissas()->toArray()
        );
        $this->assertSame(
            [2.0, 3.0],
            $dataset->ordinates()->toArray()
        );
    }

    /**
     * @expectedException Innmind\Math\Exception\VectorsMustContainsOnlyTwoValuesException
     */
    public function testThrowWhenNotUsingTwoDimensionalDataset()
    {
        new Dataset(
            new RowVector(1, 2, 3)
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
                [0.0, 1.0],
                [1.0, 2.0],
                [2.0, 3.0],
                [3.2, 4.0],
            ],
            $dataset->toArray()
        );
    }
}
