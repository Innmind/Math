<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Probabilities;

use Innmind\Math\{
    Probabilities\BinomialDistribution,
    Algebra\Number,
    Algebra\Real,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class BinomialDistributionTest extends TestCase
{
    public function testInvokation()
    {
        $law = BinomialDistribution::of(Real::of(0.5));

        $probability = $law(9, 2);

        $this->assertInstanceOf(Number::class, $probability);
        $this->assertSame(0.0703125, $probability->value());
    }
}
