<x-filament-widgets::widget class="fi-wi-group">
    <x-filament::tabs>
        @foreach($this->getCachedTabs() as $key=> $tab)
            <x-filament::tabs.item
                :key="$key"
                :active="$this->isActiveTab($key)"

                :badge="$tab->getBadge()"
                :badge-color="$tab->getBadgeColor()"

                :icon="$tab->getIcon()"
                :icon-position="$tab->getIconPosition()"
                :attributes="$tab->getExtraAttributeBag()"
                wire:click="setActiveTab('{{ $key }}')"
            >
                {{ $tab->getLabel() }}
            </x-filament::tabs.item>
        @endforeach
    </x-filament::tabs>

    <div
        {{
            $attributes->grid($this->getColumns())->class(['fi-wi-widget mt-4 gap-6']),
        }}
    >
        @foreach($this->getActiveWidgets() as $widget)
            @livewire($widget)
        @endforeach
    </div>

</x-filament-widgets::widget>