<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TenantCreateCommand extends Command
{
    // the tenant config layout
    const CONFIG_DATA =  <<<END
    <?php

    return [
        'app' => [
            'name'      => '%s',
            'url'       => %s,
            'domains'   => [
                %s,
            ],
        ]
    ];
    END;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:create 
        {--name= : The name of the tenant (ex. `Youtube`, `Facebook`)} 
        {--code= : The short name of the tenant (ex. `yt`, `fb`)} 
        {--domain= : The main domain the tenant can be accessed (ex. `youtube.test`, `facebook.test`)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for creating a Tenant';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // validation process
        $validation = validator()->make($this->options(), [
            'name'      => 'required|unique:tenants,name',
            'code'      => 'required|max:5|unique:tenants,code',
            'domain'    => 'required'
        ]);

        if ($validation->fails()) {
            foreach ($validation->errors()->toArray() as $errors) {
                foreach ($errors as $error) {
                    $this->error("ERROR: {$error}");
                }
            }

            return Command::INVALID;
        }

        try {
            // get the options
            $options = $this->options();

            // create tenant
            $tenant = new Tenant();
            $tenant->code = Str::slug($options['code'], '');
            $tenant->name = ucwords($options['name']);
            $tenant->save();


            // if tenant was not created
            if (!$tenant->wasRecentlyCreated) {
                $this->error('Failed to create tenant');
                return Command::FAILURE;
            }

            // create the tenant config
            $this->createConfig($tenant);

            // add some cache clear here if tenant service provider is using cache

            $this->info('Tenant added');

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error('ERROR: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Create the tenant config
     * 
     * @param  Tenant $tenant
     * 
     * @return void
     */
    protected function createConfig(Tenant $tenant)
    {
        // config path
        $configPath = "tenants/{$tenant->code}.php";

        // tenant app url
        $appUrl = sprintf("env('%s_APP_URL', '%s')", strtoupper($tenant->code), $this->option('domain'));

        // skip creating config file it already exist
        if (file_exists(config_path($configPath))) {
            $this->warn('config file exists. create skipped');
            return;
        }

        // config file content
        $configData = sprintf(self::CONFIG_DATA, $tenant->name, $appUrl, $appUrl);

        // store the config
        File::put(config_path($configPath), $configData);

        if (!file_exists(config_path($configPath))) {
            throw new Exception("config file not created {$configPath}");
        }
    }
}
