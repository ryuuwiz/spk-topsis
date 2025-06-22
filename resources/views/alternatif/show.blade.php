<x-layouts.app :title="__('Alternatif Details') . ': ' . $alternatif->nama">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('Alternatif Details') }}: {{ $alternatif->nama }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('alternatif.edit', $alternatif) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('Edit Alternatif') }}
                </a>
                <a href="{{ route('alternatif.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to Alternatif') }}
                </a>
            </div>
        </div>

        <!-- Alternatif Content -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <!-- Alternatif Header -->
            <div class="flex items-center mb-8">
                <div class="ml-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $alternatif->nama }}</h1>
                </div>
            </div>

            <!-- Alternatif Information Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="bg-gray-50 dark:bg-zinc-700 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Basic Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alternatif ID</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $alternatif->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $alternatif->nama }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                {{ $alternatif->deskripsi ?: 'No description provided.' }}
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
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $alternatif->created_at->format('M d, Y \a\t H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $alternatif->updated_at->format('M d, Y \a\t H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Age</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $alternatif->created_at->diffForHumans() }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- TOPSIS Ranking Information -->
                <div class="bg-gray-50 dark:bg-zinc-700 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">TOPSIS Ranking</h3>
                    @php
                        $topsisRank = $alternatif->getTopsisRank();
                    @endphp

                    @if($topsisRank)
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Rank</dt>
                                <dd class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $topsisRank['rank'] }}
                                    @if($topsisRank['rank'] == 1)
                                        <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Top Ranked</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">TOPSIS Score</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ number_format($topsisRank['score'], 4) }}</dd>
                            </div>
                        </dl>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">No TOPSIS ranking available. This may be due to missing ratings or criteria.</p>
                    @endif
                </div>
            </div>

            <!-- Actions Section -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('alternatif.edit', $alternatif) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Alternatif
                    </a>

                    <form action="{{ route('alternatif.destroy', $alternatif) }}" method="POST" class="inline"
                          onsubmit="return confirm('Are you sure you want to delete this alternatif? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-700 text-white text-sm font-medium rounded-md transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Alternatif
                        </button>
                    </form>

                    <a href="{{ route('alternatif.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Alternatif
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
