<?php

namespace App\System\Providers;

use App\Modules\Projetos\Providers\ProjetosServiceProvider;
use App\System\Business\CoreConfiguracaoBusiness;
use App\System\Business\EmpresaBusiness;
use App\System\Business\EmpresaConfiguracaoBusiness;
use App\System\Business\EquipeBusiness;
use App\System\Business\UserBusiness;
use App\System\Component\Assinatura;
use App\System\Component\ComboEquipes;
use App\System\Component\DeleteModal;
use App\System\Component\GenericModal;
use App\System\Component\UploadModal;
use App\System\Config\MenuConfig;
use App\System\Contracts\Business\CoreConfiguracaoBusinessContract;
use App\System\Contracts\Business\EmpresaBusinessContract;
use App\System\Contracts\Business\EmpresaConfiguracaoBusinessContract;
use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Contracts\Business\UserBusinessContract;
use App\System\Contracts\Repository\EmpresaConfiguracaoRepositoryContract;
use App\System\Contracts\Repository\EmpresaRepositoryContract;
use App\System\Contracts\Repository\EquipeRepositoryContract;
use App\System\Contracts\Repository\UserRepositoryContract;
use App\System\Impl\ServiceProviderAbstract;
use App\System\Repositorys\EmpresaConfiguracaoRepository;
use App\System\Repositorys\EmpresaRepository;
use App\System\Repositorys\EquipeRepository;
use App\System\Repositorys\UserRepository;
use App\System\Services\Mail\DTOs\MailDTO;
use App\System\Services\Mail\QTesteMail;
use App\System\Traits\Configuracao;
use App\System\Utils\RequestGuard;
use App\System\Utils\RequestGuardApi;
use App\System\Utils\RequestGuardWeb;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use League\Flysystem\Filesystem;
use ReflectionClass;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

class AppServiceProvider extends ServiceProvider
{
    use Configuracao;
    public $bindings = [
        UserBusinessContract::class => UserBusiness::class,
        UserRepositoryContract::class => UserRepository::class,
        EquipeBusinessContract::class => EquipeBusiness::class,
        EquipeRepositoryContract::class => EquipeRepository::class,
        EmpresaBusinessContract::class => EmpresaBusiness::class,
        EmpresaRepositoryContract::class => EmpresaRepository::class,
        EmpresaConfiguracaoRepositoryContract::class => EmpresaConfiguracaoRepository::class,
        EmpresaConfiguracaoBusinessContract::class => EmpresaConfiguracaoBusiness::class,
        CoreConfiguracaoBusinessContract::class => CoreConfiguracaoBusiness::class
    ];
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
        Storage::extend('dropbox', function (Application $app, array $config) {
            $adapter = new DropboxAdapter(new Client(
                $config['authorization_token']
            ));

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
        $this->app->singleton(RequestGuard::class, function (Application $app) {
            if(request()->is('api/*')){
                return new RequestGuardApi();
            }else{
                return new RequestGuardWeb();
            }
        });
        MenuConfig::configureMenuModule();

        Blade::component('delete-modal', DeleteModal::class);
        Blade::component('combo-equipes', ComboEquipes::class);
        Blade::component('upload-modal', UploadModal::class);
        Blade::component('generic-modal', GenericModal::class);
        Blade::component('assinatura', Assinatura::class);

        if ($this->app->environment('production')) {
            $this->app['request']->server->set('HTTPS','on');

        }

    }

}
