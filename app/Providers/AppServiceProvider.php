<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'Pessoa Física' => 'App\Models\PessoaFisica', 
            'Pessoa Jurídica' => 'App\Models\PessoaJuridica',
            'Fornecedor' => 'App\Models\Fornecedor',
            'User' => 'App\Models\User',
            'Setor' => 'App\Models\UnidadeAdministrativa',
            'Uasg' => 'App\Models\Uasg',
        ]);
    }
}
