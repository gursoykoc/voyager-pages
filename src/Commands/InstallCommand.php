<?php

namespace Pvtl\VoyagerPages\Commands;

use Pvtl\VoyagerPages\Providers\PagesServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'voyager-pages:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Voyager Pages package';

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd() . '/composer.phar')) {
            return '"' . PHP_BINARY . '" ' . getcwd() . '/composer.phar';
        }

        return 'composer';
    }

    public function fire(Filesystem $filesystem)
    {
        return $this->handle($filesystem);
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Publishing Pages assets, database, and config files');
        $this->call('vendor:publish', ['--provider' => PagesServiceProvider::class]);

        $this->info('Dumping the autoloaded files and reloading all new files');
        $composer = $this->findComposer();
        $process = new Process([$composer, 'dump-autoload']);
        $process->setTimeout(null); // Setting timeout to null to prevent installation from stopping at a certain point in time
        $process->setWorkingDirectory(base_path())->mustRun();

        $this->info('Successfully installed Voyager Pages!');
    }
}
