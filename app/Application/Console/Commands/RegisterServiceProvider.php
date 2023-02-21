<?php

namespace App\Application\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RegisterServiceProvider extends Command
{
    const SERVICE_PROVIDER_CLASS = "App\Application\Abstracts\ServiceProviderAbstract";
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'provider:register {provider}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registra o service provier em arquivo app.php';

    private function providerIsValid(string $provider):bool
    {
        return class_exists($provider) &&
                get_parent_class($provider) == self::SERVICE_PROVIDER_CLASS &&
                $this->providerIsRegistered($provider);
    }
    private function providerIsRegistered(string $provider):bool
    {
        $class = new \ReflectionClass($this->argument('provider'));
        if(in_array($class->name,config('app.providers')))
        {
            $this->alert("Provider já registrado");
            return false;
        }
        return true;
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if($this->providerIsValid($this->argument('provider'))) {

            $configFile = base_path() . '/config/app.php';
            $searchFor =
                <<<COMMENT
                'providers' => [
                COMMENT;
            $file = file_get_contents($configFile);

            $customProviders = strpos($file, $searchFor.PHP_EOL);
            $newFile = substr_replace($file, $searchFor.PHP_EOL."\t\t".$this->argument('provider').'::class,', $customProviders, strlen($searchFor));
            file_put_contents($configFile, $newFile);
            $this->info("Provider registrado com sucesso!");

        }
        else
            $this->error("Não foi possível registrar o provider");
    }
}
