<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Polynom;

use Innmind\Math\Polynom\Degree;
use PHPUnit\Framework\TestCase;

class DegreeTest extends TestCase
{
    public function testDegree()
    {
        $d = new Degree(8, 2);

        $this->assertSame(8, $d->degree());
        $this->assertSame(2.0, $d->coeff());
        $this->assertSame(512.0, $d(2));
    }
}
