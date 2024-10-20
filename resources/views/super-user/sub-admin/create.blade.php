<x-super-user-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Sub Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('superuser.subadmins.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" 
                                class="mt-1 block w-full" 
                                :value="old('name')" 
                                 autofocus autocomplete="name" 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div class="mb-4">
                          <x-input-label for="email" :value="__('Email')" />
                          <x-text-input id="email" name="email" type="email" 
                            class="mt-1 block w-full" 
                            :value="old('email')" 
                             autocomplete="email" 
                          />
                          <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                        <div class="mb-4">
                          <x-input-label for="password" :value="__('Password')" />
                          <x-text-input id="password" name="password" type="password" 
                            class="mt-1 block w-full" 
                            :value="old('password')" 
                            
                          />
                          <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        <div>
                          <x-primary-button>{{ __('Create Sub Admin') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-super-user-app-layout>
