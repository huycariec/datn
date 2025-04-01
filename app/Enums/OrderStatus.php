<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING_CONFIRMATION = 'pending_confirmation';
    case CONFIRMED = 'confirmed';
    case PREPARING = 'preparing';
    case PREPARED = 'prepared';
    case PICKED_UP = 'picked_up';
    case IN_TRANSIT = 'in_transit';
    case DELIVERED = 'delivered';
    case RECEIVED = 'received';
    case CANCELLED = 'cancelled';
    case RETURNED = 'returned';
    case REFUNDED = 'refunded';

    /**
     * Get the display name for the status
     */
    public function label(): string
    {
        return match($this) {
            self::PENDING_CONFIRMATION => 'Chờ xác nhận',
            self::CONFIRMED => 'Đã xác nhận',
            self::PREPARING => 'Đang chuẩn bị hàng',
            self::PREPARED => 'Đã chuẩn bị xong & chờ lấy hàng',
            self::PICKED_UP => 'Đã lấy hàng',
            self::IN_TRANSIT => 'Đang giao hàng',
            self::DELIVERED => 'Đã giao hàng',
            self::RECEIVED => 'Đã nhận được hàng',
            self::CANCELLED => 'Đã hủy',
            self::RETURNED => 'Trả hàng',
            self::REFUNDED => 'Đã hoàn tiền',
        };
    }

    /**
     * Get the status with Bootstrap 5 badge styling
     */
    public function getBadgeLabel(): string
    {
        return match($this) {
            self::PENDING_CONFIRMATION => '<span class="badge bg-secondary">' . $this->label() . '</span>',
            self::CONFIRMED => '<span class="badge bg-info">' . $this->label() . '</span>',
            self::PREPARING => '<span class="badge bg-warning text-dark">' . $this->label() . '</span>',
            self::PREPARED => '<span class="badge bg-warning">' . $this->label() . '</span>',
            self::PICKED_UP => '<span class="badge bg-primary">' . $this->label() . '</span>',
            self::IN_TRANSIT => '<span class="badge bg-info">' . $this->label() . '</span>',
            self::DELIVERED => '<span class="badge bg-success">' . $this->label() . '</span>',
            self::RECEIVED => '<span class="badge bg-success">' . $this->label() . '</span>',
            self::CANCELLED => '<span class="badge bg-danger">' . $this->label() . '</span>',
            self::RETURNED => '<span class="badge bg-primary">' . $this->label() . '</span>',
            self::REFUNDED => '<span class="badge bg-dark">' . $this->label() . '</span>',
        };
    }

    /**
     * Get all statuses as array
     */
    public static function toArray(): array
    {
        return array_map(
            fn(self $status) => [
                'value' => $status->value,
                'label' => $status->label(),
            ],
            self::cases()
        );
    }
}
