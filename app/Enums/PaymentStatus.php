<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED = 'failed';

    /**
     * Get the display name for the payment method
     */
    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Đang chờ',
            self::SUCCESS => 'Thành công',
            self::FAILED => 'Thất bại',
        };
    }

    /**
     * Get the payment method with Bootstrap 5 badge styling
     */
    public function getBadgeLabel(): string
    {
        return match($this) {
            self::PENDING => '<span class="badge bg-danger">' . $this->label() . '</span>',
            self::SUCCESS => '<span class="badge bg-primary">' . $this->label() . '</span>',
            self::FAILED => '<span class="badge bg-info">' . $this->label() . '</span>',
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
