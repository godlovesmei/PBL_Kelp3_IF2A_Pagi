<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;
use Illuminate\Support\Facades\URL;

class OrderSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        // Generate the URL for viewing the order
        $orderUrl = url(route('user.orders.show', $this->order->order_id, false)); // ✅ aman
        return (new MailMessage)
            ->subject('Pesanan Anda Telah Diajukan')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Pesanan Anda untuk mobil telah berhasil diajukan.')
            ->line('Mobil: ' . $this->order->car->model)
            ->line('Total Harga: Rp ' . number_format($this->order->total_price, 0, ',', '.'))
            ->action('Lihat Pesanan', $orderUrl)
            ->line('Terima kasih telah menggunakan layanan kami!');
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @param  object  $notifiable
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id'     => $this->order->order_id,
            'car_model'     => $this->order->car->model ?? '-',
            'total_price'  => $this->order->total_price,
            'message'      => 'Pesanan Anda untuk mobil ' . ($this->order->car->model ?? '-') . ' telah berhasil diajukan.',
            'url'          => url(route('user.orders.show', $this->order->order_id, false)), // ✅ aman
    ];
    }
}
