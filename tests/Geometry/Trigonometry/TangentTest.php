<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\Tangent,
    Geometry\Angle\Degree,
    Algebra\NumberInterface,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class TangentTest extends TestCase
{
    public function testInterface()
    {
        $tan = new Tangent(new Degree(new Number(42)));

        $this->assertInstanceOf(NumberInterface::class, $tan());
        $this->assertSame(0.90040404429784, $tan()->value());
    }
}
