<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Statistics;

use Innmind\Math\{
    Statistics\Frequence,
    Algebra\Number,
    Algebra\Integer,
    Algebra\Division
};
use PHPUnit\Framework\TestCase;

class FrequenceTest extends TestCase
{
    public function testInvokation()
    {
        $frequence = Frequence::of(
            Integer::of(1),
            Integer::of(2),
            Integer::of(2),
            Integer::of(1),
            Integer::of(3),
        );

        $this->assertInstanceOf(Division::class, $frequence(Integer::of(1)));
        $this->assertInstanceOf(Division::class, $frequence(Integer::of(4)));
        $this->assertSame('2 ÷ 5', $frequence(Integer::of(1))->toString());
        $this->assertSame('0 ÷ 5', $frequence(Integer::of(4))->toString());
        $this->assertInstanceOf(Number::class, $frequence->size());
        $this->assertSame(5, $frequence->size()->value());
    }
}
