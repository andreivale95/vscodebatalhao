<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */

    //'App\Models\User' => 'App\Policies\UserPolicy',

    //'App\Models\User' => 'App\Policies\UserPolicy',

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verificação de Email')
                ->line('Clique no botão abaixo para verificar seu endereço de e-mail.')
                ->action('Verificar Email', $url);
        });


        $this->registerPolicies();

        Gate::define('autorizacao', function (User $user, int $permissao) {
            $permissoes = $user->perfil()->get()->first()->permissoes()->get();
            foreach ($permissoes as $per) {
                if ($per->fk_permissao == $permissao)
                    return true;
            }
            return false;
        });

        Gate::define('modulo', function (User $user, $modulo) {
            $permissoes = $user->perfil()->get()->first()->permissoes()->get();
            foreach ($permissoes as $per) {
                //dd($per->permissao()->first()->grupo);
                if ($per->permissao()->first()->modulo == $modulo) {
                    return true;
                }
            }
            return false;
        });

        Gate::define('interno', function (User $user) {
            if ($user->tipo == 'i') {
                return true;
            }
            return false;
        });
    }
}
