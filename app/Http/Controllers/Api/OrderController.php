<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $orderService) {}

    public function store(Request $request): JsonResponse
    {
        $paymentMethod = $request->input('paymentMethod');

        if (! in_array($paymentMethod, ['cod', 'card'], true)) {
            return response()->json(['error' => 'Invalid payment method.'], 400);
        }

        $result = $this->orderService->create($request->all());

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], $result['status']);
        }

        return response()->json($result['order'], 201);
    }

    public function show(string $orderId): JsonResponse
    {
        $order = $this->orderService->find($orderId);

        if ($order === null) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        return response()->json([
            'id' => $order->id,
            'orderNumber' => $order->order_number,
            'status' => $order->status,
            'paymentMethod' => $order->payment_method,
            'paymentStatus' => $order->payment_status,
            'customer' => [
                'name' => $order->customer_name,
                'city' => $order->customer_city,
            ],
            'items' => $order->items->map(fn ($item) => [
                'name' => $item->name,
                'quantity' => $item->quantity,
                'lineTotal' => $item->line_total,
            ])->values(),
            'total' => $order->total,
            'cardPayment' => $order->card_last4
                ? [
                    'brand' => $order->card_brand,
                    'last4' => $order->card_last4,
                    'transactionId' => $order->card_transaction_id,
                ]
                : null,
            'createdAt' => $order->created_at?->toISOString(),
        ]);
    }
}
