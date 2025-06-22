<x-layouts.app :title="__('Create New Kriteria')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('Create New Kriteria') }}
            </h2>
            <a href="{{ route('kriteria.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to Kriteria') }}
            </a>
        </div>

        <!-- Create Kriteria Form -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <form method="POST" action="{{ route('kriteria.store') }}">
                @csrf

                <!-- Nama -->
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('Nama') }}
                    </label>
                    <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autofocus
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white @error('nama') border-red-500 @enderror">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bobot -->
                <div class="mb-4">
                    <label for="bobot" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('Bobot') }}
                    </label>
                    <input id="bobot" type="number" name="bobot" value="{{ old('bobot') }}" required step="0.01" min="0" max="1"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white @error('bobot') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        {{ __('Enter a value between 0 and 1.') }}
                    </p>
                    @error('bobot')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Atribut -->
                <div class="mb-6">
                    <label for="atribut" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('Atribut') }}
                    </label>
                    <select id="atribut" name="atribut" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white @error('atribut') border-red-500 @enderror">
                        <option value="">{{ __('Select Atribut') }}</option>
                        <option value="benefit" {{ old('atribut') == 'benefit' ? 'selected' : '' }}>{{ __('Benefit') }}</option>
                        <option value="cost" {{ old('atribut') == 'cost' ? 'selected' : '' }}>{{ __('Cost') }}</option>
                    </select>
                    @error('atribut')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ __('Create Kriteria') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
