<?php

namespace App\Console\Commands;

use App\Jobs\ValidateLease;
use App\Models\Prestamo;
use Illuminate\Console\Command;

class LeaseValidatorDispatcher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:lease-validator-dispatcher';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecutar los trabajos para validar las fechas de los préstamos.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando validación de fechas en los prestamos...(suspenso)');

        foreach (Prestamo::cursor() as $record) {
            ValidateLease::dispatch($record);
        }

        $this->info('Terminado!');
        return Command::SUCCESS;
    }
}
