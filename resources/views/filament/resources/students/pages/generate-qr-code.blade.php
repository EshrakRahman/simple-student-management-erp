<x-filament-panels::page>
    @script
        <script>
            $wire.on('print', () => {
                window.print();
            });
        </script>
    @endscript

    <x-filament-panels::header title="Student QR Code" description="Scan this QR code to view student information"
        :actions="[
            \Filament\Actions\Action::make('download')
                ->label('Download QR Code')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->action('downloadQrCode'),
            \Filament\Actions\Action::make('print')
                ->label('Print')
                ->icon('heroicon-o-printer')
                ->color('gray')
                ->action('printPage'),
        ]" />

    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <div class="flex flex-col md:flex-row gap-8 items-center">
            <div class="flex-shrink-0">
                <div class="p-4 bg-white border rounded-lg shadow-sm">
                    {!! $this->getQrCode() !!}
                </div>

                <div class="mt-4 text-center">
                    {{-- <x-filament::button wire:click="downloadQrCode" icon="heroicon-o-arrow-down-tray" color="primary"
                        size="sm">
                        Download QR Code
                    </x-filament::button> --}}
                </div>
            </div>

            {{-- <div class="flex-grow">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Student Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Student ID</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $this->getRecord()->id }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Name</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $this->getRecord()->name }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $this->getRecord()->email }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Class</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $this->getRecord()->class?->name ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Section</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $this->getRecord()->section?->name ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">QR Code Data</p>
                        <p class="font-mono text-xs text-gray-600 dark:text-gray-300 break-all mt-1">
                            {{ json_encode([
                                'id' => $this->getRecord()->id,
                                'name' => $this->getRecord()->name,
                                'email' => $this->getRecord()->email,
                                'class' => $this->getRecord()->class?->name,
                                'section' => $this->getRecord()->section?->name,
                            ]) }}
                        </p>
                    </div>
                </div>
                
                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">How to use this QR code</h4>
                            <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                <p>1. Scan this QR code with any smartphone camera or QR code scanner app</p>
                                <p>2. The scanned data contains the student's information in JSON format</p>
                                <p>3. You can download the QR code as an image for printing or sharing</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</x-filament-panels::page>
