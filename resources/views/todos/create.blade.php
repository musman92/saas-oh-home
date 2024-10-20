<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Create New Todo') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <form action="{{ route('todos.store') }}" method="POST">
            @csrf
            <div class="mb-4">
              <x-input-label for="title" :value="__('Title')" />
              <x-text-input id="title" name="title" type="text" 
                class="mt-1 block w-full" 
                :value="old('title')" 
                autofocus autocomplete="title" 
              />
              <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>
            <div class="mb-4">
              <x-input-label for="description" :value="__('Description')" />
              <x-text-input id="description" name="description" type="text" 
                class="mt-1 block w-full" 
                :value="old('description')" 
              />
              <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>

              <div>
                <x-primary-button>{{ __('Create Todo') }}</x-primary-button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
