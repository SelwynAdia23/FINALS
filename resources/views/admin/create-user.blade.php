<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create User Account') }}
            </h2>
            <a href="{{ route('admin.users') }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; Back to Users</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.users.store') }}" class="p-6">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Full Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email Address')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="role" :value="__('Role')" />
                        <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Select Role</option>
                            <option value="faculty" {{ old('role') == 'faculty' ? 'selected' : '' }}>Faculty</option>
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Registrar / Staff</option>
                            <option value="maintenance" {{ old('role') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="department" :value="__('Department (Optional)')" />
                        <x-text-input id="department" class="block mt-1 w-full" type="text" name="department" :value="old('department')" placeholder="e.g., Registrar, Engineering" />
                        <x-input-error :messages="$errors->get('department')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="phone" :value="__('Phone Number (Optional)')" />
                        <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" placeholder="e.g., 09123456789" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.users') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                        <x-primary-button>
                            {{ __('Create Account') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
