<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Probabilities;

use Innmind\Math\{
    Probabilities\BinomialDistribution,
    Algebra\Number,
    Algebra\Integer
};
use PHPUnit\Framework\TestCase;

class BinomialDistributionTest extends TestCase
{
    public function testInvokation()
    {
        $law = BinomialDistribution::of(Number\Number::of(0.5));

        $probability = $law(Integer::of(9), Integer::of(2));

        $this->assertInstanceOf(Number::class, $probability);
        $this->assertSame(0.0703125, $probability->value());
    }
}
