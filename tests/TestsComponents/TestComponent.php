<?php

namespace Joserick\LaravelLivewireDiscover\Tests\TestsComponents;

use Livewire\Component;

class TestComponent extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div>
            Laravel Livewire Discover
        </div>
        HTML;
    }
}
