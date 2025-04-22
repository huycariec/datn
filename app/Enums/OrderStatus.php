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
    case NOT_RECEIVED = 'not_received';
    case RETURNED_ACCEPT = 'returned_accept';

    /**
     * Get the display name for the status
     */
    public function label(): string
    {
        return match($this) {
            self::PENDING_CONFIRMATION => 'Chờ xác nhận',
            self::CONFIRMED => 'Đã xác nhận',
            //  của admin, admin chỉ được xác nhận 3 trạng thái thêm giao cho ship, bỏ 3 trạng thái đang cbi, đã cbi xong, shipper đã lấy
            self::PREPARING => 'Đang chuẩn bị hàng',
            self::PREPARED => 'Đã chuẩn bị xong & chờ shipper lấy hàng',
            self::PICKED_UP => 'Shipper đã lấy hàng',


            self::IN_TRANSIT => 'Shipper đang giao hàng',
            self::DELIVERED => 'Đơn hàng đã được giao cho người nhận',
            //shipper 2 trạng thái
            self::RECEIVED => 'Hoàn thành',
            self::CANCELLED => 'Đã hủy',

            self::RETURNED => 'Trả hàng',
            self::REFUNDED => 'Đã hoàn tiền',
            self::NOT_RECEIVED => 'Không nhận được hàng',
            self::RETURNED_ACCEPT => 'Chấp nhận hoàn hàng',
        };
    }

    /**
     * Get the status with Bootstrap 5 badge styling
     */
    public function getBadgeLabel(): string
    {
        return match($this) {
            self::PENDING_CONFIRMATION => '<span class="badge bg-success">' . $this->label() . '</span>',
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
            self::NOT_RECEIVED => '<span class="badge bg-danger">' . $this->label() . '</span>',
            self::RETURNED_ACCEPT => '<span class="badge bg-success">' . $this->label() . '</span>',
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
