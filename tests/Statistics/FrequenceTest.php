<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Statistics;

use Innmind\Math\{
    Statistics\Frequence,
    Algebra\Number,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class FrequenceTest extends TestCase
{
    public function testInvokation()
    {
        $frequence = Frequence::of(
            Number::of(1),
            Number::of(2),
            Number::of(2),
            Number::of(1),
            Number::of(3),
        );

        $this->assertSame('2 ÷ 5', $frequence(Number::of(1))->toString());
        $this->assertSame('0 ÷ 5', $frequence(Number::of(4))->toString());
        $this->assertSame(5, $frequence->size());
    }
}
