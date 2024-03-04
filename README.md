
![laravel_livewire_discover.jpg](https://joserick.com/livewire_discover.jpg)
# Laravel Livewire Discover
![Packagist Downloads](https://img.shields.io/packagist/dt/joserick/laravel-livewire-discover?color=blue)   ![GitHub License](https://img.shields.io/github/license/joserick/laravel-livewire-discover) ![GitHub Release](https://img.shields.io/github/v/release/joserick/laravel-livewire-discover?color=2da711)

Automatically discover and load/register multiple/different class namespaces for Livewire components.

## Installation

You can install the package via composer:

``` bash
composer require joserick/laravel-livewire-discover
```
## Enjoying this package? [!["Buy Me A Coffee"](https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png)](https://www.buymeacoffee.com/joserick)
## Config
Add to *AppServiceProvider.php*
``` php
public function boot(): void
{
	// Load multiples namespace for Livewire components.
	Livewire::discover('Namespaces\\Livewire', 'my-components');
	Livewire::discover('User\\Repository\\Livewire', 'new-components');
	...
}
```
**Or** use the config: *'config/laravel-livewire-discover.php'*
``` bash
# Publish the config
php artisan vendor:publish --tag livewire-discover-config
```
``` php
// Load the namespace to Livewire components.
'class_namespaces' => [
	// 'prefix' => 'namespace\\package',
	'my-components' => 'Namespaces\\Livewire',
	'new-components' => 'User\\Repository\\Livewire',
],
```
## Use
``` html
<!-- Call Livewire Components. -->
<livewire:my-components-devices /> <!-- Class: Namespace\Livewire\Devices; -->
<livewire:new-components-devices-table /> <!-- Class: User\Repository\Livewire\DevicesTable; -->
```
#### Or
``` php
// Load Livewire Component from Route
use Namespaces\Livewire\Devices;
use User\Repository\Livewire\DevicesTable;

Route::get('/devices', Devices::class); // resolve name my-components-devices
Route::get('/devices_table', DevicesTable::class); // resolve name new-components-devices-table
```
## License

The GNU Public License (GPLv3). Please see [License File](https://github.com/joserick/laravel-livewire-discover/blob/master/LICENSE) for more information.
