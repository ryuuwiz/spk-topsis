<x-layouts.app :title="__('Create New Rating')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('Create New Rating') }}
            </h2>
            <a href="{{ route('rating.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to Ratings') }}
            </a>
        </div>

        <!-- Create Rating Form -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <form method="POST" action="{{ route('rating.store') }}">
                @csrf

                <!-- Alternatif -->
                <div class="mb-4">
                    <label for="id_alternatif" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('Alternatif') }}
                    </label>
                    <select id="id_alternatif" name="id_alternatif" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white @error('id_alternatif') border-red-500 @enderror">
                        <option value="">{{ __('Select Alternatif') }}</option>
                        @foreach($alternatif as $alternatif)
                            <option value="{{ $alternatif->id }}" {{ old('id_alternatif') == $alternatif->id ? 'selected' : '' }}>
                                {{ $alternatif->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_alternatif')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kriteria -->
                <div class="mb-4">
                    <label for="id_kriteria" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('Kriteria') }}
                    </label>
                    <select id="id_kriteria" name="id_kriteria" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white @error('id_kriteria') border-red-500 @enderror">
                        <option value="">{{ __('Select Kriteria') }}</option>
                        @foreach($kriteria as $kriteria)
                            <option value="{{ $kriteria->id }}" {{ old('id_kriteria') == $kriteria->id ? 'selected' : '' }}>
                                {{ $kriteria->nama }} ({{ ucfirst($kriteria->atribut) }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_kriteria')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nilai -->
                <div class="mb-6">
                    <label for="nilai" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('Nilai') }}
                    </label>
                    <input id="nilai" type="number" name="nilai" value="{{ old('nilai') }}" required step="0.01" min="0"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white @error('nilai') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        {{ __('Enter a numeric value for this rating.') }}
                    </p>
                    @error('nilai')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ __('Create Rating') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
