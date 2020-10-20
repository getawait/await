<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Question\Question;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'await:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simplify installation process';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->welcome();

        $this->createEnvFile();

        $this->generateKey();

        $credentials = $this->requestDatabaseCredentials();

        $this->updateEnvironmentFile($credentials);

        $this->migrateDatabase($credentials);

        $this->call('cache:clear');

        $this->goodbye();
    }

    /**
     * Display the welcome message.
     */
    protected function welcome(): void
    {
        $this->info('>> Welcome to the Await installation process! <<');
    }

    /**
     * Create the initial .env file.
     */
    protected function createEnvFile(): void
    {
        if (! file_exists('.env')) {
            copy('.env.example', '.env');

            $this->line('.env file successfully created');
        }
    }

    /**
     * Generate the project secret key.
     */
    protected function generateKey(): void
    {
        if (strlen(config('app.key')) === 0) {
            $this->call('key:generate');

            $this->line('~ Secret key properly generated.');
        }
    }

    /**
     * Request the local database details from the user.
     *
     * @return array
     */
    protected function requestDatabaseCredentials(): array
    {
        return [
            'DB_DATABASE' => $this->ask('Database name', 'await'),
            'DB_PORT' => $this->ask('Database port', 3306),
            'DB_USERNAME' => $this->ask('Database user'),
            'DB_PASSWORD' => $this->askHiddenWithDefault('Database password (leave blank for no password)'),
        ];
    }

    /**
     * Prompt the user for optional input but hide the answer from the console.
     *
     * @param string $question
     * @param bool $fallback
     * @return string
     */
    protected function askHiddenWithDefault(string $question, bool $fallback = true): string
    {
        $question = new Question($question, 'null');

        $question->setHidden(true)->setHiddenFallback($fallback);

        return $this->output->askQuestion($question);
    }

    /**
     * Update the .env file from an array of $key => $value pairs.
     *
     * @param  array $updatedValues
     * @return void
     */
    protected function updateEnvironmentFile(array $updatedValues): void
    {
        $envFile = $this->laravel->environmentFilePath();

        foreach ($updatedValues as $key => $value) {
            file_put_contents($envFile, preg_replace(
                "/{$key}=(.*)/",
                "{$key}={$value}",
                file_get_contents($envFile)
            ));
        }

        $this->line('~ .env file updated.');
    }

    /**
     * Asks if want to run the database migrations.
     *
     * @param array $credentials
     */
    protected function migrateDatabase(array $credentials): void
    {
        if ($this->confirm('Do you want to migrate the database?', false)) {
            $this->migrateDatabaseWithFreshCredentials($credentials);

            $this->line('~ Database successfully migrated.');
        }
    }

    /**
     * Migrate the db with the new credentials.
     *
     * @param array $credentials
     * @return void
     */
    protected function migrateDatabaseWithFreshCredentials(array $credentials): void
    {
        foreach ($credentials as $key => $value) {
            $configKey = strtolower(str_replace('DB_', '', $key));

            if ($configKey === 'password' && $value == 'null') {
                config(["database.connections.mysql.{$configKey}" => '']);

                continue;
            }

            config(["database.connections.mysql.{$configKey}" => $value]);
        }

        $this->call('migrate');
    }

    /**
     * Display the completion message.
     */
    protected function goodbye(): void
    {
        $this->info('>> The installation process is complete. Enjoy your new viral waiting list! <<');
    }
}
