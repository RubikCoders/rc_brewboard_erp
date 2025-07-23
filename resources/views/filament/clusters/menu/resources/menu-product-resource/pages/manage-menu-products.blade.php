<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total de Productos</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-success-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Productos Disponibles</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $availableProducts }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-info-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-info-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Categorías</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $categoriesCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Form with Tabs --}}
        <div class="bg-white rounded-xl shadow-sm border">
            <form wire:submit="create">
                {{ $this->form }}
                
                {{-- Form Actions - Only show in Register tab --}}
                <div class="px-6 py-4 border-t bg-gray-50 rounded-b-xl" 
                     x-data="{ activeTab: @entangle('activeTab') }" 
                     x-show="activeTab === 'register_products' || !activeTab">
                    <div class="flex justify-end space-x-3">
                        {{ $this->createAction }}
                        {{ $this->createAnotherAction }}
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Custom Styles for the Classic Theme --}}
    <style>
        /* Enhanced tabs styling for clusters */
        .fi-tabs {
            @apply bg-white rounded-xl border shadow-sm;
        }
        
        .fi-tabs-header {
            @apply border-b border-gray-200 bg-gray-50/50 rounded-t-xl;
        }
        
        .fi-tab-item {
            @apply px-6 py-4 text-sm font-medium transition-all duration-200;
        }
        
        .fi-tab-item[aria-selected="true"] {
            @apply text-primary-600 border-b-2 border-primary-600 bg-white -mb-px;
        }
        
        .fi-tab-item[aria-selected="false"] {
            @apply text-gray-500 hover:text-gray-700 hover:bg-gray-50;
        }
        
        /* Enhanced form sections */
        .fi-section {
            @apply mb-6 rounded-lg;
        }
        
        .fi-section-header {
            @apply mb-4;
        }
        
        .fi-section-content {
            @apply bg-gray-50/30 rounded-lg p-4;
        }
        
        /* Stats cards responsive */
        @media (max-width: 768px) {
            .grid-cols-1.md\\:grid-cols-3 {
                grid-template-columns: 1fr;
            }
        }
        
        /* Action buttons enhancement */
        .fi-btn {
            @apply transition-all duration-200;
        }
        
        .fi-btn:hover {
            @apply transform scale-105;
        }
        
        /* Cluster-specific enhancements */
        .fi-cluster-navigation {
            @apply border-b border-gray-200 bg-white;
        }
        
        .fi-cluster-nav-item {
            @apply px-4 py-2 text-sm font-medium transition-colors;
        }
        
        .fi-cluster-nav-item.active {
            @apply text-primary-600 border-b-2 border-primary-600;
        }
    </style>

    {{-- JavaScript for enhanced interactions --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced tab interactions
            const tabs = document.querySelectorAll('.fi-tab-item');
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Add smooth transition effects
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 100);
                });
            });

            // Auto-refresh statistics every 30 seconds
            setInterval(() => {
                if (typeof Livewire !== 'undefined') {
                    Livewire.emit('refreshStats');
                }
            }, 30000);
        });
    </script>
</x-filament-panels::page>