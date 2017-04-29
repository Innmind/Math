<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\Cosine,
    Geometry\Angle\Degree,
    Algebra\NumberInterface,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class CosineTest extends TestCase
{
    public function testInterface()
    {
        $cos = new Cosine(new Degree(new Number(42)));

        $this->assertInstanceOf(NumberInterface::class, $cos());
        $this->assertSame(0.74314482547739, $cos()->value());
    }
}
