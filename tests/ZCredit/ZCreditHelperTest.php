<?php

namespace ZCredit;

use PHPUnit\Framework\TestCase;

class ZCreditHelperTest extends TestCase
{
    public function testPay()
    {
        $helper = new ZCreditHelper();

        $this->assertInstanceOf(ZCreditHelper::class, $helper);
    }
}
