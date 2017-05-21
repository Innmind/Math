<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Geometry\Trigonometry;

use Innmind\Math\{
    Geometry\Trigonometry\ArcCosine,
    Geometry\Trigonometry\Cosine,
    Geometry\Angle\Degree,
    Algebra\Number
};
use PHPUnit\Framework\TestCase;

class ArcCosineTest extends TestCase
{
    public function testInterface()
    {
        $acos = new ArcCosine(
            new Cosine(new Degree(new Number(42)))
        );

        $this->assertInstanceOf(Degree::class, $acos());
        $this->assertSame('42°', (string) $acos());
    }
}
