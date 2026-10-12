<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\ReservasiService;

class KirimEmailReservasi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reservasi;

    /**
     * Create a new job instance.
     *
     * @param ReservasiService $reservasi
     */
    public function __construct(ReservasiService $reservasi)
    {
        $this->reservasi = $reservasi;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {

            $customerEmail = $this->reservasi->service?->appointment?->customer?->email
                             ?? 'reservasi@laravel.test';

            Log::info('Mulai mengirim email reservasi', [
                'reservasi_id' => $this->reservasi->id,
                'to' => $customerEmail
            ]);
            Mail::raw(
                "Halo, reservasi Anda dikonfirmasi.\n\n".
                "Tanggal: {$this->reservasi->tanggal_booking}\n".
                "Jam: {$this->reservasi->jam_booking}\n".
                "Status: {$this->reservasi->status}",
                function ($message) use ($customerEmail) {
                    $message->to($customerEmail)
                            ->subject('Reservasi Dikonfirmasi');
                }
            );

            Log::info('Email berhasil dikirim', [
                'reservasi_id' => $this->reservasi->id,
                'to' => $customerEmail
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal kirim email reservasi', [
                'reservasi_id' => $this->reservasi->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
