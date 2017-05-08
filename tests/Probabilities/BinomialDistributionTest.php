<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Probabilities;

use Innmind\Math\{
    Probabilities\BinomialDistribution,
    Algebra\NumberInterface,
    Algebra\Number,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class BinomialDistributionTest extends TestCase
{
    public function testInvokation()
    {
        $law = new BinomialDistribution(new Number(0.5));

        $probability = $law(new Integer(9), new Integer(2));

        $this->assertInstanceOf(NumberInterface::class, $probability);
        $this->assertSame(0.0703125, $probability->value());
    }
}
