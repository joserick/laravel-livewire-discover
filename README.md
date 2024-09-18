![laravel_livewire_discover.jpg](https://joserick.com/livewire_discover.jpg)
# Laravel Livewire Discover
![Packagist Downloads](https://img.shields.io/packagist/dt/joserick/laravel-livewire-discover?color=blue)   ![GitHub License](https://img.shields.io/github/license/joserick/laravel-livewire-discover) ![GitHub Release](https://img.shields.io/github/v/release/joserick/laravel-livewire-discover?color=2da711)
> Notice: [Migration to v1.0](https://github.com/joserick/laravel-livewire-discover#migration-to-v1) || [I need previous version (v0.3)](https://github.com/joserick/laravel-livewire-discover#i-need-for-v0.3.2)

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
  Livewire::discovers([
    'my-components', 'Namespaces\\Livewire',
    'new-components', 'User\\Repository\\Livewire',
  ]);

  // Or individually
  Livewire::discover('my-components', 'Namespaces\\Livewire');
  Livewire::discover('new-components', 'User\\Repository\\Livewire');
}
```
Or if you like, use "componentNamespace" function as in [Blade Templates](https://laravel.com/docs/blade#clipText-53)
``` php
public function boot(): void
{
  // Load multiples namespace for Livewire components.
  Livewire::componentNamespace('Namespaces\\Livewire', 'my-components');
  Livewire::componentNamespace('User\\Repository\\Livewire', 'new-components');
  // ...
}
```
**Or** use the config: *'config/laravel-livewire-discover.php'*
``` bash
php artisan vendor:publish --tag livewire-discover-config
```
``` php
// Load the namespace to Livewire components.
'class_namespaces' => [
  // 'prefix' => 'class\\namespace',
  'my-components' => 'Namespaces\\Livewire',
  'new-components' => 'User\\Repository\\Livewire',
],
```
## Use
Call Livewire Components:
``` html
<livewire:my-components.devices /> <!-- Class: Namespace\Livewire\Devices; -->
<livewire:new-components.auth.login /> <!-- Class: User\Repository\Livewire\Auth\Login; -->
<livewire:new-components.auth.register-admin /> <!-- Class: User\Repository\Livewire\Auth\RegisterAdmin; -->
```
Or use form Routes:
``` php
// Load Livewire Component from Route
use Namespaces\Livewire\Devices;
use User\Repository\Livewire\DevicesTable;

Route::get('/devices', Devices::class); // resolve name my-components.devices
Route::get('/devices_table', DevicesTable::class); // resolve name new-components.devices-table
```
"Obviously" you need to install the "layout" first for the Routes
```bash
php artisan livewire:layout
```
## Config path for component creation
If you would like to automatically create components in a specific directory based on the prefix, you can configure it in the following way:
``` php
public function boot(): void
{
  Livewire::discover('my-components', 'Namespaces\\Livewire', '/path/livewire');
}
```
## Creating components
You can create the files automatically using the following Artisan command. In the process it will ask you for the suffix to use, don't forget to put the path in the prefix settings.
```bash
php artisan make:livewire-discover RegisterAdmin
```
If you prefer kebab-cased names, you can use them as well:
```bash
php artisan make:livewire-discover register-admin
```
You may use namespace syntax or dot-notation to create your components in sub-directories. For example, the following commands will create a `RegisterAdmin` component in the `Auth` sub-directory:
```bash
php artisan make:livewire-discover Auth\\RegisterAdmin
php artisan make:livewire-discover auth.register-admin
```
## Migration to v1
Replace `Livewire::discover` for `Livewire::componentNamespace` since the attributes in v1 are reversed but the `componentNamespace` function maintains the structure of previous versions.
``` php
Livewire::discover('Namespaces\\Livewire', 'my-components');
```
to
``` php
Livewire::componentNamespace('Namespaces\\Livewire', 'my-components');
```
or in any case to maintain the use of the `discover()` function you can invert the parameters.

Change in concatenation of prefixes with class name, previously it was concatenated using the "-" notation, now the dot-notation is used, so it must be changed in all calls to Livewire-Discover components
``` html
<livewire:components-devices />
```
to
``` html
<livewire:components.devices />
```
## I need for v0.3.2
```
composer require joserick/laravel-livewire-discover:0.3.2
```

## License

The GNU Public License (GPLv3). Please see [License File](https://github.com/joserick/laravel-livewire-discover/blob/master/LICENSE) for more information.
