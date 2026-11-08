<?php

declare(strict_types=1);

namespace Nodelapay\Nodela\Resources;

use InvalidArgumentException;
use Nodelapay\Nodela\Http\Response;

class Billing extends BaseResource
{
    private const CHECKOUT_ACTIONS = [
        'resolve', 'payment-options', 'prepare-payment', 'prepare-authorization',
        'authorize', 'authorize-and-collect', 'payment-status',
        'prepare-revocation', 'confirm-revocation',
    ];

    protected function getBaseEndpoint(): string
    {
        return '/';
    }

    public function createCustomer(array $params): Response
    {
        return $this->request->post('/customers', $params);
    }
    public function createSubscription(array $params): Response
    {
        return $this->request->post('/subscriptions', $params);
    }
    public function listSubscriptions(array $query = []): Response
    {
        return $this->request->get('/subscriptions', $query);
    }
    public function getSubscription(string $subscriptionId): Response
    {
        return $this->request->get('/subscriptions/' . rawurlencode($subscriptionId));
    }
    public function listInvoices(array $query = []): Response
    {
        return $this->request->get('/billing-invoices', $query);
    }
    public function listMandates(array $query = []): Response
    {
        return $this->request->get('/mandates', $query);
    }
    public function recordUsage(array $params): Response
    {
        return $this->request->post('/usage-events', $params);
    }
    public function usageAggregate(array $query): Response
    {
        return $this->request->get('/usage-events/aggregate', $query);
    }
    public function customerBilling(string $customerId, array $query = []): Response
    {
        return $this->request->get('/customers/' . rawurlencode($customerId) . '/billing', $query);
    }

    public function checkoutSession(string $sessionId, string $clientSecret, string $action, array $params = []): Response
    {
        if (! in_array($action, self::CHECKOUT_ACTIONS, true)) {
            throw new InvalidArgumentException('Unsupported checkout action: ' . $action);
        }

        return $this->request->post(
            '/billing/checkout-sessions/' . rawurlencode($sessionId) . '/' . $action,
            $params,
            ['X-Client-Secret' => $clientSecret]
        );
    }
}
