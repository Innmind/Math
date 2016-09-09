<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Polynom;

use Innmind\Math\Polynom\Polynom;
use Innmind\Math\Polynom\Degree;

class PolynomTest extends \PHPUnit_Framework_TestCase
{
    public function testImmutability()
    {
        $p = new Polynom(0);

        $this->assertNotSame($p, $p->withDegree(1, 1));
    }

    public function testDegree()
    {
        $p = (new Polynom(0))->withDegree(1, 1);

        $this->assertTrue($p->hasDegree(1));
        $this->assertFalse($p->hasDegree(2));
        $this->assertInstanceOf(Degree::class, $p->degree(1));

        $p = new Polynom(0, [$d = new Degree(1, 2)]);

        $this->assertTrue($p->hasDegree(1));
        $this->assertSame($d, $p->degree(1));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Unknown index 2
     */
    public function testThrowIfTryingToAccessUnknownDegree()
    {
        $p = new Polynom(0);

        $p->degree(2);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Each value must be an instance of "Innmind\Math\Polynom\Degree"
     */
    public function testThrowIfTryingToBuildPolynomWithInvalidData()
    {
        new Polynom(0, [1 => 1]);
    }

    public function testIntercept()
    {
        $p = new Polynom(42);

        $this->assertSame(42.0, $p->intercept());
    }

    public function testCompute()
    {
        $p = (new Polynom(42))
            ->withDegree(1, 2)
            ->withDegree(2, 1);

        $this->assertSame(50.0, $p(2));
    }

    public function testOnlyOneDegreePresentInAPolynom()
    {
        $p = (new Polynom(42))
            ->withDegree(2, 2)
            ->withDegree(2, 3);

        $this->assertSame(54.0, $p(2));
    }
}
