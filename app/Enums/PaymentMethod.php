<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case MOMO = 'MOMO';
    case VNPAY = 'VNPAY';
    case CASH = 'CASH';

    /**
     * Get the display name for the payment method
     */
    public function label(): string
    {
        return match($this) {
            self::MOMO => 'Momo',
            self::VNPAY => 'Vnpay',
            self::CASH => 'Tiền mặt',
        };
    }

    /**
     * Get the payment method with Bootstrap 5 badge styling
     */
    public function getBadgeLabel(): string
    {
        return match($this) {
            self::MOMO => '<span class="badge bg-info">' . $this->label() . '</span>',
            self::VNPAY => '<span class="badge bg-danger">' . $this->label() . '</span>',
            self::CASH => '<span class="badge bg-primary">' . $this->label() . '</span>',
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
