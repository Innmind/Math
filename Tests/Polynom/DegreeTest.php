<?php

namespace Innmind\Math\Tests\Polynom;

use Innmind\Math\Polynom\Degree;

class DegreeTest extends \PHPUnit_Framework_TestCase
{
    public function testDegree()
    {
        $d = new Degree(8, 2);

        $this->assertSame(8.0, $d->degree());
        $this->assertSame(2.0, $d->coeff());
        $this->assertSame(512.0, $d(2));
    }
}
