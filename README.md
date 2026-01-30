<p align="center">
    <img src="https://img.shields.io/packagist/v/octopyid/filament-tabify.svg?style=for-the-badge" alt="Version">
    <img src="https://img.shields.io/packagist/dt/octopyid/filament-tabify.svg?style=for-the-badge&color=F28D1A" alt="Downloads">
    <img src="https://img.shields.io/packagist/l/octopyid/filament-tabify.svg?style=for-the-badge" alt="License">
</p>

# Filament Tabify

Transform your Filament dashboard with elegant Tabbed Widgets. Group multiple widgets into a single, organized view to save space and improve clarity.

## Installation

You can install the package via composer:

```bash
composer require octopyid/filament-tabify
```

## Usage

To create a tabbed widget, extend the `TabsWidget` class and define your tabs using the `getTabs()` method. Each tab can contain a schema of other widgets.

```php
use Octopy\Filament\Tabify\Tab;
use Octopy\Filament\Tabify\TabsWidget;

class DashboardTabsWidget extends TabsWidget
{
    protected int|string|array $columnSpan = 'full';

    public function getTabs() : array
    {
        return [
            Tab::make('Foo')
                ->icon('lucide-chart-line')
                ->badge(100)
                ->schema([
                    Foo::class,
                    Bar::class,
                    Baz::class,
                ]),

            Tab::make('Bar')->schema([
                Qux::class,
            ]),
        ];
    }
}
```

### Registering the Widget

You can register the widget in your Filament Pages or Resources just like any other widget.

```php
use App\Filament\Widgets\DashboardTabsWidget;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getWidgets(): array
    {
        return [
            DashboardTabsWidget::class,
        ];
    }
}
```

Or in a Resource Page:

```php
use App\Filament\Widgets\DashboardTabsWidget;

class ListOrders extends \Filament\Resources\Pages\ListRecords
{
    protected function getHeaderWidgets(): array
    {
        return [
            DashboardTabsWidget::class,
        ];
    }
}
```

### Interacting with Widgets

If you need to interact with all widgets within the tabs, for example to dispatch an event to them, you can use the `getAllWidgets()` method.

```php
public function updatedYear()
{
    foreach ($this->getAllWidgets() as $widget) {
        $this->dispatch('updateYear', $this->year)->to($widget);
    }
}
```

### Customizing the Widget's Grid

You can customize the number of columns in the widget's grid by overriding the `getColumns()` method.

```php
public function getColumns(): int | array
{
    return 2;
}
```

You can also specify different column counts for different breakpoints:

```php
public function getColumns(): int | array
{
    return [
        'md' => 4,
        'xl' => 5,
    ];
}
```

### Customizing the Widget's Width

You can customize the width of the widget by overriding the `$columnSpan` property.

```php
protected int | string | array $columnSpan = 'full';
```

You can also specify different column spans for different breakpoints:

```php
protected int | string | array $columnSpan = [
    'md' => 2,
    'xl' => 3,
];
```

## Changelog

Please see [releases](https://github.com/OctopyID/FilamentTabify/releases) for more information on what has changed recently.

## Security Vulnerabilities

If you discover a security vulnerability within this package, please send an e-mail to Supian M via [bug@octopy.dev](mailto:supianidz@octopy.dev). All security
vulnerabilities will be promptly addressed.

## Credits

- [Supian M](https://github.com/SupianIDz)
- [All Contributors](https://github.com/OctopyID/FilamentTabify/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
