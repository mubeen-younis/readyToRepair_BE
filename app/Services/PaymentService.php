<?php

namespace App\Services;

class PaymentService
{
    /**
     * @param  array{name: string, number: string, expiry: string, cvv: string}  $card
     * @return array{success: true, transaction_id: string, last4: string, brand: string}|array{success: false, error: string}
     */
    public function processCardPayment(int $amount, array $card): array
    {
        $validation = $this->validateCard($card);

        if (! $validation['valid']) {
            return ['success' => false, 'error' => $validation['error']];
        }

        usleep(1_500_000);

        $digits = preg_replace('/\D/', '', $card['number']) ?? '';
        $lastDigit = (int) substr($digits, -1);

        if ($lastDigit === 0) {
            return [
                'success' => false,
                'error' => 'Payment declined by your bank. Try another card or use cash on delivery.',
            ];
        }

        return [
            'success' => true,
            'transaction_id' => sprintf(
                'TXN-%s-%s',
                (int) round(microtime(true) * 1000),
                strtoupper(substr(bin2hex(random_bytes(4)), 0, 6))
            ),
            'last4' => $validation['last4'],
            'brand' => $validation['brand'],
        ];
    }

    /**
     * @param  array{name: string, number: string, expiry: string, cvv: string}  $card
     * @return array{valid: true, last4: string, brand: string}|array{valid: false, error: string}
     */
    private function validateCard(array $card): array
    {
        $number = preg_replace('/\D/', '', $card['number']) ?? '';
        $cvv = preg_replace('/\D/', '', $card['cvv']) ?? '';
        $name = trim($card['name']);
        $expiry = trim($card['expiry']);

        if ($name === '') {
            return ['valid' => false, 'error' => 'Enter the name on your card.'];
        }

        if (strlen($number) < 13 || strlen($number) > 19) {
            return ['valid' => false, 'error' => 'Enter a valid card number.'];
        }

        if (! $this->luhnCheck($number)) {
            return ['valid' => false, 'error' => 'Card number is invalid.'];
        }

        if (! preg_match('/^(\d{2})\s*\/\s*(\d{2})$/', $expiry, $matches)) {
            return ['valid' => false, 'error' => 'Enter expiry as MM/YY.'];
        }

        $month = (int) $matches[1];
        $year = 2000 + (int) $matches[2];

        if ($month < 1 || $month > 12) {
            return ['valid' => false, 'error' => 'Expiry month is invalid.'];
        }

        $expiryDate = now()->setDate($year, $month, 1)->endOfMonth();

        if ($expiryDate->isPast()) {
            return ['valid' => false, 'error' => 'This card has expired.'];
        }

        $brand = $this->detectCardBrand($number);
        $cvvLength = $brand === 'Amex' ? 4 : 3;

        if (strlen($cvv) !== $cvvLength) {
            return ['valid' => false, 'error' => "Enter a valid {$cvvLength}-digit CVV."];
        }

        return [
            'valid' => true,
            'last4' => substr($number, -4),
            'brand' => $brand,
        ];
    }

    private function luhnCheck(string $cardNumber): bool
    {
        $sum = 0;
        $shouldDouble = false;

        for ($i = strlen($cardNumber) - 1; $i >= 0; $i--) {
            $digit = (int) $cardNumber[$i];

            if ($shouldDouble) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
            $shouldDouble = ! $shouldDouble;
        }

        return $sum % 10 === 0;
    }

    private function detectCardBrand(string $cardNumber): string
    {
        if (preg_match('/^4/', $cardNumber)) {
            return 'Visa';
        }

        if (preg_match('/^5[1-5]/', $cardNumber) || preg_match('/^2[2-7]/', $cardNumber)) {
            return 'Mastercard';
        }

        if (preg_match('/^3[47]/', $cardNumber)) {
            return 'Amex';
        }

        if (preg_match('/^6(?:011|5)/', $cardNumber)) {
            return 'Discover';
        }

        return 'Card';
    }
}
