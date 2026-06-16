<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(private readonly PaymentService $paymentService) {}

    /**
     * @param  array{
     *     customer: array{name: string, email: string, phone: string, address: string, city: string},
     *     items: list<array{id: string, quantity: int}>,
     *     paymentMethod: string,
     *     card?: array{name: string, number: string, expiry: string, cvv: string}
     * }  $input
     * @return array{order: array<string, mixed>}|array{error: string, status: int}
     */
    public function create(array $input): array
    {
        $customerError = $this->validateCustomer($input['customer'] ?? []);

        if ($customerError !== null) {
            return ['error' => $customerError, 'status' => 400];
        }

        $resolved = $this->resolveOrderItems($input['items'] ?? []);

        if (isset($resolved['error'])) {
            return ['error' => $resolved['error'], 'status' => 400];
        }

        $paymentMethod = $input['paymentMethod'] ?? '';
        $total = $resolved['subtotal'];
        $paymentStatus = 'pending';
        $status = 'confirmed';
        $cardBrand = null;
        $cardLast4 = null;
        $cardTransactionId = null;

        if ($paymentMethod === 'card') {
            if (! isset($input['card'])) {
                return ['error' => 'Card details are required for card payment.', 'status' => 400];
            }

            $payment = $this->paymentService->processCardPayment($total, $input['card']);

            if (! $payment['success']) {
                return ['error' => $payment['error'], 'status' => 402];
            }

            $paymentStatus = 'paid';
            $cardBrand = $payment['brand'];
            $cardLast4 = $payment['last4'];
            $cardTransactionId = $payment['transaction_id'];
        }

        $orderId = (string) Str::uuid();
        $orderNumber = $this->createOrderNumber();
        $customer = $input['customer'];

        $order = DB::transaction(function () use (
            $orderId,
            $orderNumber,
            $status,
            $paymentMethod,
            $paymentStatus,
            $customer,
            $resolved,
            $total,
            $cardBrand,
            $cardLast4,
            $cardTransactionId,
        ) {
            $order = Order::query()->create([
                'id' => $orderId,
                'order_number' => $orderNumber,
                'status' => $status,
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentStatus,
                'customer_name' => trim($customer['name']),
                'customer_email' => trim($customer['email'] ?? ''),
                'customer_phone' => trim($customer['phone']),
                'customer_address' => trim($customer['address']),
                'customer_city' => trim($customer['city']),
                'subtotal' => $resolved['subtotal'],
                'total' => $total,
                'card_brand' => $cardBrand,
                'card_last4' => $cardLast4,
                'card_transaction_id' => $cardTransactionId,
            ]);

            foreach ($resolved['items'] as $item) {
                $order->items()->create($item);
            }

            return $order->load('items');
        });

        return [
            'order' => [
                'orderId' => $order->id,
                'orderNumber' => $order->order_number,
                'status' => $order->status,
                'paymentStatus' => $order->payment_status,
                'paymentMethod' => $order->payment_method,
                'total' => $order->total,
            ],
        ];
    }

    public function find(string $orderId): ?Order
    {
        return Order::query()->with('items')->find($orderId);
    }

    /**
     * @param  array{name?: string, email?: string, phone?: string, address?: string, city?: string}  $customer
     */
    private function validateCustomer(array $customer): ?string
    {
        if (trim($customer['name'] ?? '') === '') {
            return 'Name is required.';
        }

        if (trim($customer['phone'] ?? '') === '') {
            return 'Phone number is required.';
        }

        if (trim($customer['address'] ?? '') === '') {
            return 'Delivery address is required.';
        }

        if (trim($customer['city'] ?? '') === '') {
            return 'City is required.';
        }

        $email = trim($customer['email'] ?? '');

        if ($email !== '' && ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Enter a valid email address.';
        }

        return null;
    }

    /**
     * @param  list<array{id: string, quantity: int}>  $items
     * @return array{items: list<array<string, mixed>>, subtotal: int}|array{error: string}
     */
    private function resolveOrderItems(array $items): array
    {
        if ($items === []) {
            return ['error' => 'Your cart is empty.'];
        }

        $resolved = [];
        $subtotal = 0;

        foreach ($items as $item) {
            $quantity = $item['quantity'] ?? 0;

            if (! is_int($quantity) || $quantity < 1) {
                return ['error' => 'Invalid item quantity.'];
            }

            $product = Product::query()->find($item['id'] ?? '');

            if ($product === null) {
                return ['error' => 'Product not found: '.($item['id'] ?? '')];
            }

            $lineTotal = $product->price * $quantity;
            $subtotal += $lineTotal;

            $resolved[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'unit_price' => $product->price,
                'quantity' => $quantity,
                'line_total' => $lineTotal,
            ];
        }

        return ['items' => $resolved, 'subtotal' => $subtotal];
    }

    private function createOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $suffix = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));

        return "RTR-{$date}-{$suffix}";
    }
}
