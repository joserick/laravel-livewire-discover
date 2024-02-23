# Laravel Livewire Discover
![Packagist Downloads](https://img.shields.io/packagist/dt/joserick/laravel-livewire-discover?color=blue)   ![GitHub License](https://img.shields.io/github/license/joserick/laravel-livewire-discover) ![GitHub Release](https://img.shields.io/github/v/release/joserick/laravel-livewire-discover?color=2da711)

Automatically discover and load/register multiple/different class namespaces for Livewire components.

## Installation

You can install the package via composer:

``` bash
composer require joserick/laravel-livewire-discover
```
[!["Buy Me A Coffee"](https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png)](https://www.buymeacoffee.com/joserick)
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
