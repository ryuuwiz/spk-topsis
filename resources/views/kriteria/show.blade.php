<x-layouts.app :title="__('Kriteria Details') . ': ' . $kriterium->nama">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('Kriteria Details') }}: {{ $kriterium->nama }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('kriteria.edit', $kriterium) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('Edit Kriteria') }}
                </a>
                <a href="{{ route('kriteria.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to Kriteria') }}
                </a>
            </div>
        </div>

        <!-- Kriteria Content -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <!-- Kriteria Header -->
            <div class="flex items-center mb-8">
                <div class="ml-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $kriterium->nama }}</h1>
                    <div class="mt-2">
                        @if($kriterium->atribut == 'benefit')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Benefit
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                Cost
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kriteria Information Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="bg-gray-50 dark:bg-zinc-700 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Basic Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kriteria ID</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $kriterium->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $kriterium->nama }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Bobot</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $kriterium->bobot }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Atribut</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                @if($kriterium->atribut == 'benefit')
                                    <span class="text-green-600 dark:text-green-400">Benefit</span>
                                @else
                                    <span class="text-red-600 dark:text-red-400">Cost</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Additional Information -->
                <div class="bg-gray-50 dark:bg-zinc-700 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Additional Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $kriterium->created_at->format('M d, Y \a\t H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $kriterium->updated_at->format('M d, Y \a\t H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Age</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $kriterium->created_at->diffForHumans() }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Actions Section -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('kriteria.edit', $kriterium) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Kriteria
                    </a>

                    <form action="{{ route('kriteria.destroy', $kriterium) }}" method="POST" class="inline"
                          onsubmit="return confirm('Are you sure you want to delete this kriteria? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-700 text-white text-sm font-medium rounded-md transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Kriteria
                        </button>
                    </form>

                    <a href="{{ route('kriteria.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Kriteria
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
