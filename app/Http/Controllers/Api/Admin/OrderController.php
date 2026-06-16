<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    private const STATUSES = ['confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];

    private const PAYMENT_STATUSES = ['pending', 'paid', 'failed', 'refunded'];

    public function index(Request $request): JsonResponse
    {
        $perPage = min(max((int) $request->integer('per_page', 15), 1), 50);
        $page = max((int) $request->integer('page', 1), 1);

        $paginator = Order::query()
            ->withCount('items')
            ->orderByDesc('created_at')
            ->paginate(perPage: $perPage, page: $page);

        return response()->json([
            'data' => collect($paginator->items())->map(fn (Order $order) => [
                'id' => $order->id,
                'orderNumber' => $order->order_number,
                'status' => $order->status,
                'paymentMethod' => $order->payment_method,
                'paymentStatus' => $order->payment_status,
                'customerName' => $order->customer_name,
                'customerCity' => $order->customer_city,
                'itemCount' => $order->items_count,
                'total' => $order->total,
                'createdAt' => $order->created_at?->toISOString(),
            ])->values(),
            'meta' => [
                'currentPage' => $paginator->currentPage(),
                'lastPage' => $paginator->lastPage(),
                'perPage' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ]);
    }

    public function show(string $orderId): JsonResponse
    {
        $order = Order::query()->with('items')->find($orderId);

        if ($order === null) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        return response()->json($this->transformDetail($order));
    }

    public function update(Request $request, string $orderId): JsonResponse
    {
        $order = Order::query()->with('items')->find($orderId);

        if ($order === null) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        $data = $request->validate([
            'status' => ['sometimes', 'required', Rule::in(self::STATUSES)],
            'paymentStatus' => ['sometimes', 'required', Rule::in(self::PAYMENT_STATUSES)],
        ]);

        if (array_key_exists('status', $data)) {
            $order->status = $data['status'];
        }

        if (array_key_exists('paymentStatus', $data)) {
            $order->payment_status = $data['paymentStatus'];
        }

        $order->save();

        return response()->json($this->transformDetail($order));
    }

    /**
     * @return array<string, mixed>
     */
    private function transformDetail(Order $order): array
    {
        return [
            'id' => $order->id,
            'orderNumber' => $order->order_number,
            'status' => $order->status,
            'paymentMethod' => $order->payment_method,
            'paymentStatus' => $order->payment_status,
            'customer' => [
                'name' => $order->customer_name,
                'email' => $order->customer_email,
                'phone' => $order->customer_phone,
                'address' => $order->customer_address,
                'city' => $order->customer_city,
            ],
            'items' => $order->items->map(fn ($item) => [
                'id' => $item->id,
                'productId' => $item->product_id,
                'name' => $item->name,
                'image' => $item->image,
                'unitPrice' => $item->unit_price,
                'quantity' => $item->quantity,
                'lineTotal' => $item->line_total,
            ])->values(),
            'subtotal' => $order->subtotal,
            'total' => $order->total,
            'cardPayment' => $order->card_last4
                ? [
                    'brand' => $order->card_brand,
                    'last4' => $order->card_last4,
                    'transactionId' => $order->card_transaction_id,
                ]
                : null,
            'createdAt' => $order->created_at?->toISOString(),
            'updatedAt' => $order->updated_at?->toISOString(),
        ];
    }
}
