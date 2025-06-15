<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class NewCarOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pesanan Mobil Baru')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Ada pesanan mobil baru dengan detail berikut:')
            ->line('Mobil: ' . $this->order->car->name)
            ->line('Total Harga: Rp ' . number_format($this->order->total_price, 0, ',', '.'))
            ->line('Metode Pembayaran: ' . ucfirst($this->order->payment_method))
            ->when($this->order->payment_method === 'credit', function ($mail) {
                return $mail
                    ->line('Tenor: ' . $this->order->tenor . ' bulan')
                    ->line('Cicilan per bulan: Rp ' . number_format($this->order->monthly_installment, 0, ',', '.'));
            })
            ->action('Lihat Detail Pesanan', url('/orders/' . $this->order->order_id))
            ->line('Terima kasih telah menggunakan layanan kami!');
    }

    /**
     * Get the array representation of the notification for database.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->order_id,
            'car_model' => $this->order->car->name, // <-- TAMBAHKAN INI
            'total_price' => $this->order->total_price,
            'payment_method' => $this->order->payment_method,
            'tenor' => $this->order->tenor,
            'monthly_installment' => $this->order->monthly_installment,
            'message' => 'Pesanan mobil baru telah dibuat.',
        ];
    }
}
