<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Registra os canais de broadcast.
     *
     * @return void
     */
    public function boot()
    {
        // Registra as rotas de broadcast
        Broadcast::routes();

        // Carrega o arquivo de canais (certifique-se de criar o arquivo routes/channels.php conforme explicado)
        require base_path('routes/channels.php');
    }
}
