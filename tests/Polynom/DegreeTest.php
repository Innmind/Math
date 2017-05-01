<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Polynom;

use Innmind\Math\{
    Polynom\Degree,
    Algebra\Number,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class DegreeTest extends TestCase
{
    public function testDegree()
    {
        $d = new Degree(new Integer(8), new Number(2));

        $this->assertSame(8, $d->degree()->value());
        $this->assertSame(2, $d->coeff()->value());
        $this->assertSame(512, $d(new Number(2))->value());
    }
}
