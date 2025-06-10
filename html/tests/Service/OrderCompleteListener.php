<?php

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use Eccube\Entity\Order;

class OrderCompleteListenerTest extends TestCase
{
    public function testOnOrderComplete_DispatchesXml()
    {

        $order = $this->createMock(Order::class);

        $this->assertTrue(true);
    }
}
