<x-layouts.app :title="__('Edit User') . ': ' . $user->name">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('Edit User') }}: {{ $user->name }}
            </h2>
            <a href="{{ route('users.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to Users') }}
            </a>
        </div>

        <!-- Edit User Form -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('Name') }}
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white @error('name') border-red-500 @enderror">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('Email') }}
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Verified -->
                <div class="mb-4">
                    <div class="flex items-center">
                        <input id="email_verified" type="checkbox" name="email_verified" value="1" {{
                            old('email_verified', $user->email_verified_at) ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded
                        dark:bg-zinc-700">
                        <label for="email_verified"
                            class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Email Verified') }}
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        {{ __('Check this box to mark the email as verified.') }}
                        @if($user->email_verified_at)
                        {{ __('Currently verified on') }} {{ $user->email_verified_at->format('M d, Y') }}.
                        @else
                        {{ __('Currently not verified.') }}
                        @endif
                    </p>
                </div>

                <!-- Password (Optional) -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('New Password') }} <span class="text-gray-500 dark:text-gray-400">(leave blank to keep
                            current)</span>
                    </label>
                    <input id="password" type="password" name="password"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white @error('password') border-red-500 @enderror">
                    @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('Confirm New Password') }}
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white">
                </div>

                <!-- User Info Display -->
                <div class="mb-6 p-4 bg-gray-50 dark:bg-zinc-700 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">User Information</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-gray-600 dark:text-gray-400">ID:</span>
                            <span class="text-gray-900 dark:text-white">{{ $user->id }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600 dark:text-gray-400">Email Verified:</span>
                            <span class="text-gray-900 dark:text-white">
                                @if($user->email_verified_at)
                                <span class="text-green-600 dark:text-green-400">Yes ({{
                                    $user->email_verified_at->format('M d, Y') }})</span>
                                @else
                                <span class="text-red-600 dark:text-red-400">No</span>
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600 dark:text-gray-400">Created:</span>
                            <span class="text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y H:i')
                                }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600 dark:text-gray-400">Last Updated:</span>
                            <span class="text-gray-900 dark:text-white">{{ $user->updated_at->format('M d, Y H:i')
                                }}</span>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        {{ __('Update User') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>