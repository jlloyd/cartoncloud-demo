<?php

namespace App\Module\PurchaseOrder;

class PurchaseOrderManager
{

    protected $client;
    protected $calculator;

    public function __construct(
        $purchaseOrderClient,
        $purchaseOrderCalculator
    ) {
        $this->client = $purchaseOrderClient;
        $this->calculator = $purchaseOrderCalculator;
    }

    public function calculateProductTypeTotals($purchaseOrderIds)
    {
        $purchaseOrders = $this->client->getPurchaseOrders($purchaseOrderIds);
        return $this->calculator->calculateProductTypeTotals($purchaseOrders);
    }
}
