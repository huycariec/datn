<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case MOMO = 'momo';
    case VNPAY = 'vnpay';
    case CASH = 'cash';

    /**
     * Get the display name for the payment method
     */
    public function label(): string
    {
        return match($this) {
            self::MOMO => 'Momo',
            self::VNPAY => 'VNPAY',
            self::CASH => 'Tiền mặt',
        };
    }

    /**
     * Get the payment method with Bootstrap 5 badge styling
     */
    public function getBadgeLabel(): string
    {
        return match($this) {
            self::MOMO => '<span class="badge bg-primary">' . $this->label() . '</span>',
            self::VNPAY => '<span class="badge bg-success">' . $this->label() . '</span>',
            self::CASH => '<span class="badge bg-warning text-dark">' . $this->label() . '</span>',
        };
    }

    /**
     * Get all payment methods as array
     */
    public static function toArray(): array
    {
        return array_map(
            fn(self $method) => [
                'value' => $method->value,
                'label' => $method->label(),
            ],
            self::cases()
        );
    }
}
