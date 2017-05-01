<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Polynom;

use Innmind\Math\{
    Polynom\Polynom,
    Polynom\Degree,
    Algebra\NumberInterface,
    Algebra\Number,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class PolynomTest extends TestCase
{
    public function testImmutability()
    {
        $p = new Polynom(new Number(0));

        $this->assertNotSame(
            $p,
            $p->withDegree(new Integer(1), new Integer(1))
        );
    }

    public function testDegree()
    {
        $p = (new Polynom(new Number(0)))->withDegree(
            new Integer(1),
            new Number(1)
        );

        $this->assertTrue($p->hasDegree(1));
        $this->assertFalse($p->hasDegree(2));
        $this->assertInstanceOf(Degree::class, $p->degree(1));

        $p = new Polynom(
            new Number(0),
            $d = new Degree(new Integer(1), new Number(2))
        );

        $this->assertTrue($p->hasDegree(1));
        $this->assertSame($d, $p->degree(1));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowIfTryingToAccessUnknownDegree()
    {
        $p = new Polynom(new Number(0));

        $p->degree(2);
    }

    public function testIntercept()
    {
        $p = new Polynom($intercept = new Number(42));

        $this->assertSame($intercept, $p->intercept());
        $this->assertSame(42, $p->intercept()->value());
    }

    public function testCompute()
    {
        $p = (new Polynom(new Number(42)))
            ->withDegree(new Integer(1), new Number(2))
            ->withDegree(new Integer(2), new Number(1));

        $this->assertInstanceOf(NumberInterface::class, $p(new Number(2)));
        $this->assertSame(50, $p(new Number(2))->value());
    }

    public function testOnlyOneDegreePresentInAPolynom()
    {
        $p = (new Polynom(new Number(42)))
            ->withDegree(new Integer(2), new Number(2))
            ->withDegree(new Integer(2), new Number(3));

        $this->assertSame(54, $p(new Number(2))->value());
    }
}
