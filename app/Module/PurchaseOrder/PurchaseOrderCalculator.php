<?php

namespace App\Module\PurchaseOrder;

use RuntimeException;
use LogicException;

class PurchaseOrderCalculator
{

    protected $calculationMap = [
        1 => 'weight',
        2 => 'volume',
        3 => 'weight',
    ];

    public function calculateProductTypeTotals($purchaseOrders)
    {
        $productTypes = [];
        foreach ($purchaseOrders as $purchaseOrder) {
            foreach ($purchaseOrder['PurchaseOrderProduct'] as $purchaseOrderProduct) {
                if (!isset($productTypes[$purchaseOrderProduct['product_type_id']])) {
                    $productTypes[$purchaseOrderProduct['product_type_id']] = [
                        'product_type_id' => $purchaseOrderProduct['product_type_id'],
                        'total' => 0,
                    ];
                }
                $productTypes[$purchaseOrderProduct['product_type_id']]['total'] += $this->calculateTotal($purchaseOrderProduct);
            }
        }

        return array_values($productTypes);
    }

    public function calculateTotal($purchaseOrderProduct)
    {
        $method = $this->calculationMap[$purchaseOrderProduct['product_type_id']] ?? null;

        if ($method) {
            $method = 'calculateBy' . ucfirst($method);
        }

        if (!$method
            || !method_exists($this, $method)
        ) {
            throw new RuntimeException('Unknown calculation type');
        }

        return $this->$method($purchaseOrderProduct);
    }

    public function calculateByWeight($purchaseOrderProduct)
    {
        return $purchaseOrderProduct['unit_quantity_initial'] * $purchaseOrderProduct['Product']['weight'];
    }

    public function calculateByVolume($purchaseOrderProduct)
    {
        return $purchaseOrderProduct['unit_quantity_initial'] * $purchaseOrderProduct['Product']['volume'];
    }


    public function __call($method, $args)
    {
        throw new LogicException('Unknown calcuation type provided');
    }
}
