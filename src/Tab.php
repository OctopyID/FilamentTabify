<?php

declare(strict_types = 1);

namespace Octopy\Filament\Tabify;

use Closure;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Concerns\HasLabel;
use Filament\Support\Concerns\HasBadge;
use Filament\Support\Concerns\HasExtraAttributes;
use Filament\Support\Concerns\HasIcon;
use Filament\Support\Concerns\HasIconPosition;
use Illuminate\Contracts\Support\Htmlable;

class Tab extends Component
{
    use HasLabel, HasBadge, HasIcon, HasIconPosition, HasExtraAttributes;

    /**
     * Tab constructor.
     */
    public function __construct(Closure|Htmlable|string|null $label)
    {
        $this->label($label);
    }

    /**
     * @param  Closure|Htmlable|string|null $label
     * @return static
     */
    public static function make(Closure|Htmlable|string|null $label) : static
    {
        $static = app(static::class, [
            'label' => $label,
        ]);

        $static->configure();

        return $static;
    }

    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this
            ->key(function () {
                return (string) str($this->getLabel())->slug();
            });
    }

    /**
     * @param  bool $isAbsolute
     * @return string
     */
    public function getKey(bool $isAbsolute = true) : string
    {
        return $this->evaluate($this->key);
    }
}