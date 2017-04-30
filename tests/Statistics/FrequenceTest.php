<?php
declare(strict_types = 1);

namespace Tests\Innmind\Math\Statistics;

use Innmind\Math\{
    Statistics\Frequence,
    Algebra\NumberInterface,
    Algebra\Number,
    Algebra\Division
};
use PHPUnit\Framework\TestCase;

class FrequenceTest extends TestCase
{
    public function testInvokation()
    {
        $frequence = new Frequence(
            new Number(1),
            new Number(2),
            new Number(2),
            new Number(1),
            new Number(3)
        );

        $this->assertInstanceOf(Division::class, $frequence(new Number(1)));
        $this->assertInstanceOf(Division::class, $frequence(new Number(4)));
        $this->assertSame('2 ÷ 5', (string) $frequence(new Number(1)));
        $this->assertSame('0 ÷ 5', (string) $frequence(new Number(4)));
        $this->assertInstanceOf(NumberInterface::class, $frequence->size());
        $this->assertSame(5, $frequence->size()->value());
    }
}
