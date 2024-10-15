<?php

namespace Joserick\LaravelLivewireDiscover\Tests;

use Illuminate\Support\Facades\Facade;
use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscoverManager;
use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscoverServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected LaravelLivewireDiscoverManager $manager;

    protected string $PREFIX = 'tests';

    protected string $NAMESPACE = 'Joserick\\LaravelLivewireDiscover\\Tests';

    protected string $ALIAS;

    protected string $CLASS;

    protected string $CLASS_PATH;

    protected function setUp(): void
    {
        $this->ALIAS = $this->PREFIX.'.tests-components.test-component';
        $this->CLASS = $this->NAMESPACE.'\\TestsComponents\\TestComponent';
        $this->CLASS_PATH = $this->PREFIX.'/';

        parent::setUp();

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
}
