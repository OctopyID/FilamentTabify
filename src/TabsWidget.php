<?php

declare(strict_types = 1);

namespace Octopy\Filament\Tabify;

use Filament\Widgets\Widget;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;

abstract class TabsWidget extends Widget
{
    /**
     * @var string|null
     */
    #[Url(as: 'tab', except: null)]
    public string|null $activeTab = null;

    protected Collection|null $cachedTabs = null;

    /**
     * @var string
     */
    protected string $view = 'tabify::tabs';

    /**
     * @return int|array
     */
    public function getColumns() : int|array
    {
        return 2;
    }

    /**
     * @return array<string | int, Tab>
     */
    public function getTabs() : array
    {
        return [];
    }

    /**
     * @return Collection<string | int, Tab>
     */
    public function getCachedTabs() : Collection
    {
        return
            $this->cachedTabs ??=
                collect($this->getTabs())
                    ->mapWithKeys(function (Tab $tab, string|int $key) : array {
                        return [
                            $tab->getKey() => $tab->hasCustomLabel() ? $tab : $tab->label($this->generateTabLabel($key)),
                        ];
                    });
    }

    /**
     * @return string|int|null
     */
    public function getDefaultActiveTab() : string|int|null
    {
        return $this->getCachedTabs()->keys()->first();
    }

    /**
     * @return array
     */
    public function getActiveWidgets() : array
    {
        return $this->getActiveTab()->getDefaultChildComponents();
    }

    /**
     * @return array<int, Widget>
     */
    public function getAllWidgets() : array
    {
        $widgets = [];
        foreach ($this->getCachedTabs() as $tab) {
            $widgets = array_merge($widgets, $tab->getDefaultChildComponents());
        }

        return array_unique($widgets);
    }

    /**
     * @return Tab
     */
    public function getActiveTab() : Tab
    {
        /**
         * @var Collection<string, Tab> $tabs
         */
        $tabs = $this->getCachedTabs();

        if ($tabs->has($this->activeTab)) {
            return $tabs->get($this->activeTab);
        }

        return $tabs->get($this->getDefaultActiveTab());
    }

    /**
     * @param  string $key
     * @return void
     */
    public function setActiveTab(string $key) : void
    {
        $this->activeTab = $key;
    }

    /**
     * @param  string $key
     * @return bool
     */
    public function isActiveTab(string $key) : bool
    {
        $active = $this->activeTab;
        if (blank($active)) {
            $active = $this->getDefaultActiveTab();
        }

        return $active === $key;
    }

    /**
     * @param  string $key
     * @return string
     */
    protected function generateTabLabel(string $key) : string
    {
        return (string) str($key)->replace(['_', '-'], ' ')->ucfirst();
    }
}