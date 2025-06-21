<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Order;

class NewOrderForDealer extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Terima instance Order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Channel yang digunakan
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Data untuk disimpan di tabel notifications
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->order_id,
            'car_model' => $this->order->car->model ?? '-',
            'customer_name' => $this->order->customer->user->name ?? 'Unknown',
            'message' => 'Pesanan baru dari customer: ' . ($this->order->customer->user->name ?? 'Unknown'),
            'url' => route('pages.dealer.order-index'), // tanpa parameter
    ];
}
}
