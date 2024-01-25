# Laravel Livewire Discover

Discover and autoload multiples namespace for livewire components.

## Installation

You can install the package via composer:

``` bash
composer require joserick/laravel-livewire-discover
```
## Use
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
	// 'prefix' => '//namespace//',
	'my-components' => 'Namespace\\Livewire',
	'new-components' => 'User\\Repository\\Livewire',
],
```

## License

The GNU Public License (GPLv3). Please see [License File](https://github.com/joserick/laravel-livewire-discover/blob/master/LICENSE) for more information.

