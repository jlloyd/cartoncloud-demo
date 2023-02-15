<?php

namespace App\Integrations;

use Illuminate\Support\Facades\Http;;

class PurchaseOrderClient
{

    protected $client;

    public function __construct($endpoint, $username, $password)
    {
        $this->client = Http::baseUrl($endpoint)
            ->withBasicAuth($username, $password);
    }

    public function getPurchaseOrders($ids)
    {
        $orders = [];
        foreach ($ids as $id) {
            $orders[] = $this->getPurchaseOrder($id);
        }

        return $orders;
    }

    public function getPurchaseOrder($id)
    {
        $response = $this->client->get($id . '?version=5&associated=true');
        return json_decode($response->getBody()->__toString(), true)['data'] ?? [];
    }

}
