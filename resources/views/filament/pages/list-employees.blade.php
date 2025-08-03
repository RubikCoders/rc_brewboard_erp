<div data-page="employee-resource" class="employee-resource-tabs">
    <x-filament-panels::page>
        @if (method_exists($this, 'getTabs') && count($this->getTabs()) > 0)
            <x-filament::tabs>
                @foreach ($this->getTabs() as $tabKey => $tab)
                    <x-filament::tabs.item
                        :active="$activeTab === $tabKey"
                        :badge="$tab->getBadge()"
                        :badge-color="$tab->getBadgeColor()"
                        :icon="$tab->getIcon()"
                        :icon-position="$tab->getIconPosition()"
                        wire:click="$set('activeTab', '{{ $tabKey }}')"
                    >
                        {{ $tab->getLabel() ?? $this->generateTabLabel($tabKey) }}
                    </x-filament::tabs.item>
                @endforeach
            </x-filament::tabs>
        @endif

        {{ $this->table }}
    </x-filament-panels::page>
</div>