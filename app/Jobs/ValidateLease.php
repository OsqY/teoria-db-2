<?php

namespace App\Jobs;

use App\Models\Prestamo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ValidateLease implements ShouldQueue
{
    use Queueable, Dispatchable, SerializesModels, InteractsWithQueue;

    public $record;

    /**
     * Create a new job instance.
     */
    public function __construct(Prestamo $record)
    {
        $this->record = $record;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->record->user;

        if (!$user) {
            return;
        }
        if (!$user->sancionado && is_null($this->record->fecha_devuelto) && $this->record->fecha_devolucion_esperada < now()) {
            $user->sancionado = true;
            $user->save();
        }
    }
}
