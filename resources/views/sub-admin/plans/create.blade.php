<x-sub-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Plan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('subadmin.plans.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Plan Name')" />
                            <x-text-input id="name" name="name" type="text" 
                                class="mt-1 block w-full" 
                                :value="old('name')" 
                                required autofocus autocomplete="name" 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="amount" :value="__('Amount')" />
                            <x-text-input id="amount" name="amount" type="text" 
                                class="mt-1 block w-full" 
                                :value="old('amount')" 
                                required 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="interval" :value="__('Interval')" />
                            <select name="interval" id="interval" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="month">Monthly</option>
                                <option value="year">Yearly</option>
                            </select>
                            <!-- <x-text-input id="interval" name="interval" type="text" class="mt-1 block w-full" :value="old('amount')" required /> -->
                            <x-input-error class="mt-2" :messages="$errors->get('interval')" />
                        </div>

                        <div>
                            <x-primary-button>{{ __('Create Plan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-sub-admin-app-layout>
