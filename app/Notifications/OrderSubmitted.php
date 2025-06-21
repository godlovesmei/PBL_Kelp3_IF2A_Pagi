<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Order;

class OrderSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Hanya gunakan channel database
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Data yang disimpan di tabel notifications
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id'     => $this->order->order_id,
            'car_model'    => $this->order->car->model ?? '-',
            'total_price'  => $this->order->total_price,
            'message'      => 'Pesanan Anda untuk mobil ' . ($this->order->car->model ?? '-') . ' telah berhasil diajukan.',
            'url'          => route('user.orders.show', $this->order->order_id),
        ];
    }
}
