<x-layouts.app :title="__('Rating Details')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('Rating Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('rating.edit', $rating) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('Edit Rating') }}
                </a>
                <a href="{{ route('rating.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to Ratings') }}
                </a>
            </div>
        </div>

        <!-- Rating Content -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <!-- Rating Header -->
            <div class="flex items-center mb-8">
                <div class="ml-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Rating for {{ $rating->alternatif->nama }} - {{ $rating->kriteria->nama }}
                    </h1>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            Nilai: {{ $rating->nilai }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Rating Information Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="bg-gray-50 dark:bg-zinc-700 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Basic Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Rating ID</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $rating->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alternatif</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                <a href="{{ route('alternatif.show', $rating->alternatif) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ $rating->alternatif->nama }}
                                </a>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kriteria</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                <a href="{{ route('kriteria.show', $rating->kriteria) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ $rating->kriteria->nama }} ({{ ucfirst($rating->kriteria->atribut) }})
                                </a>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nilai</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $rating->nilai }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Additional Information -->
                <div class="bg-gray-50 dark:bg-zinc-700 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Additional Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $rating->created_at->format('M d, Y \a\t H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $rating->updated_at->format('M d, Y \a\t H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Age</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $rating->created_at->diffForHumans() }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Actions Section -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Actions</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('rating.edit', $rating) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Rating
                    </a>

                    <form action="{{ route('rating.destroy', $rating) }}" method="POST" class="inline"
                          onsubmit="return confirm('Are you sure you want to delete this rating? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-700 text-white text-sm font-medium rounded-md transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Rating
                        </button>
                    </form>

                    <a href="{{ route('rating.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Ratings
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
