
# Laravel Livewire Discover

Discover and autoload multiples namespace for livewire components.

## Installation

You can install the package via composer:

``` bash
composer require joserick/laravel-livewire-discover
```
## Config
Add to *AppServiceProvider.php*
``` php
public function boot(): void
{
	// Load multiples namespace for Livewire components.
	Livewire::discover('Namespace\\Livewire', 'my-components');
	Livewire::discover('User\\Repository\\Livewire', 'new-components');
	...
}
```
#### Or
Or use the config: *'config/laravel-livewire-discover.php'*
``` bash
# Publish the config
php artisan vendor:publish --tag livewire-discover-config
```
``` php
// Load the namespace to Livewire components.
'class_namespaces' => [
	// 'prefix' => 'namespace\\package',
	'my-components' => 'Namespace\\Livewire',
	'new-components' => 'User\\Repository\\Livewire',
],
```
## Use
``` html
// Call components.
<livewire:my-components-devices /> <!-- Class: Namespace\Livewire\Devices; -->
<livewire:new-components-devices-table /> <!-- Class: User\Repository\Livewire\DevicesTable; -->
```
## License

The GNU Public License (GPLv3). Please see [License File](https://github.com/joserick/laravel-livewire-discover/blob/master/LICENSE) for more information.

