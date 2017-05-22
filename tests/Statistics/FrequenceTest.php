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
        $frequence = new Frequence(
            new Integer(1),
            new Integer(2),
            new Integer(2),
            new Integer(1),
            new Integer(3)
        );

        $this->assertInstanceOf(Division::class, $frequence(new Integer(1)));
        $this->assertInstanceOf(Division::class, $frequence(new Integer(4)));
        $this->assertSame('2 ÷ 5', (string) $frequence(new Integer(1)));
        $this->assertSame('0 ÷ 5', (string) $frequence(new Integer(4)));
        $this->assertInstanceOf(Number::class, $frequence->size());
        $this->assertSame(5, $frequence->size()->value());
    }
}
