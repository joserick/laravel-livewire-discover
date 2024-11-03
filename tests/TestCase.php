<?php

namespace Joserick\LaravelLivewireDiscover\Tests;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscoverManager;
use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscoverServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected LaravelLivewireDiscoverManager $manager;

    protected string $PREFIX = 'tests';

    protected string $NAMESPACE = 'App\\Tests';

    protected string $ALIAS;

    protected string $CLASS;

    protected string $CLASS_PATH;

    protected string $NAMESPACE_PATH;

    protected Collection $CLASS_NAMESPACES;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ALIAS = $this->PREFIX.'.components.test-component';
        $this->CLASS = $this->NAMESPACE.'\\Components\\TestComponent';
        $this->NAMESPACE_PATH = $this->app->basePath('app/Tests');
        $this->CLASS_PATH = $this->NAMESPACE_PATH.'/Components/TestComponent.php';

        $this->CLASS_NAMESPACES = new Collection([
            $this->PREFIX => [
                'class_namespace' => $this->NAMESPACE,
                'class_path' => $this->NAMESPACE_PATH,
                'view_path' => null,
            ],
        ]);

        $this->makeTestComponent();

        $this->app->register(LaravelLivewireDiscoverServiceProvider::class);
        $this->app->register(LivewireServiceProvider::class);

        Facade::setFacadeApplication($this->app);
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelLivewireDiscoverServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }

    protected function makeTestComponent()
    {
        if (! file_exists($this->CLASS_PATH)) {
            mkdir(dirname($this->CLASS_PATH), 0755, true);

            $content = <<<PHP
                <?php

                namespace App\Tests\Components;

                use Livewire\Component;

                class TestComponent extends Component
                {
                    public function render()
                    {
                        return <<<'HTML'
                        <div>
                            {{-- Be like water. --}}
                        </div>
                        HTML;
                    }
                }
                PHP;

            file_put_contents($this->CLASS_PATH, $content);
        }
    }
}
