<?php

declare(strict_types=1);

namespace Nodelapay\Nodela\Tests\Unit;

use Nodelapay\Nodela\Http\Request;
use Nodelapay\Nodela\Http\Response;
use Nodelapay\Nodela\Resources\Billing;
use PHPUnit\Framework\TestCase;

class BillingTest extends TestCase
{
    public function testCreatesSubscription(): void
    {
        $request = $this->createMock(Request::class);
        $params = ['customer_id' => 'cus_1', 'product_id' => 'prod_1', 'idempotency_key' => 'order_1'];
        $request->expects($this->once())->method('post')->with('/subscriptions', $params)->willReturn(new Response(201, []));

        (new Billing($request))->createSubscription($params);
    }

    public function testCheckoutSessionUsesClientSecret(): void
    {
        $request = $this->createMock(Request::class);
        $request->expects($this->once())->method('post')
            ->with('/billing/checkout-sessions/session%201/resolve', [], ['X-Client-Secret' => 'secret'])
            ->willReturn(new Response(200, []));

        (new Billing($request))->checkoutSession('session 1', 'secret', 'resolve');
    }
}
