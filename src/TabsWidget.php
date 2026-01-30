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
    #[Url(as: 'tab-widget', except: null)]
    public string|null $activeTab = null;

    /**
     * @var Collection<string, Tab>|null
     */
    protected Collection|null $cachedTabs = null;

    /**
     * @var string
     */
    protected string $view = 'tabify::tabs';

    /**
     * @return array<int, Tab>
     */
    public function getTabs() : array
    {
        return [];
    }

    /**
     * @return int|array<string, int>
     */
    public function getColumns() : int|array
    {
        return 2;
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
     * @return string|int|null
     */
    public function getDefaultActiveTab() : string|int|null
    {
        return $this->getCachedTabs()->keys()->first();
    }

    /**
     * @return Tab
     */
    public function getActiveTab() : Tab
    {
        /** @var Collection<string, Tab> $tabs */
        $tabs = $this->getCachedTabs();

        if ($this->activeTab && $tabs->has($this->activeTab)) {
            return $tabs->get($this->activeTab);
        }

        return $tabs->get($this->getDefaultActiveTab());
    }

    /**
     * @return array<int, mixed>
     */
    public function getActiveWidgets() : array
    {
        return $this->getActiveTab()->getDefaultChildComponents();
    }

    /**
     * @return array<int, mixed>
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
     * @return Collection<string, Tab>
     */
    public function getCachedTabs() : Collection
    {
        if ($this->cachedTabs !== null) {
            return $this->cachedTabs;
        }

        return $this->cachedTabs = collect($this->getTabs())
            ->mapWithKeys(function (Tab $tab, string|int $key) : array {
                return [
                    $tab->getKey() => $tab->hasCustomLabel() ? $tab : $tab->label($this->generateTabLabel($key)),
                ];
            });
    }

    /**
     * @param  string|int $key
     * @return string
     */
    protected function generateTabLabel(string|int $key) : string
    {
        return (string) str((string) $key)->replace(['_', '-'], ' ')->ucfirst();
    }
}
