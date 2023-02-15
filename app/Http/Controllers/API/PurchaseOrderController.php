<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function test(Request $request)
    {
        $purchaseOrderIds = $request->input('purchase_order_ids');
        return app('purchaseOrderManager')->calculateProductTypeTotals($purchaseOrderIds);
    }
}
