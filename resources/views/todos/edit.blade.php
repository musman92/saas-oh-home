<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Update Todo') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <form action="{{ route('todos.update', $todo->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="mb-4">
              <x-input-label for="title" :value="__('Title')" />
              <x-text-input id="title" name="title" type="text" 
                class="mt-1 block w-full" 
                :value="old('title', $todo->title)" 
                autofocus autocomplete="title" 
              />
              <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>
            <div class="mb-4">
              <x-input-label for="description" :value="__('Description')" />
              <x-text-input id="description" name="description" type="text" 
                class="mt-1 block w-full" 
                :value="old('description', $todo->description)" 
              />
              <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>

            <div class="mb-4">
              <x-input-label for="status" :value="__('Status')" />
              <select name="status" id="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                  <option value="pending">Pending</option>
                  <option value="completed">Completed</option>
              </select>
              <!-- <x-text-input id="interval" name="interval" type="text" class="mt-1 block w-full" :value="old('amount')" required /> -->
              <x-input-error class="mt-2" :messages="$errors->get('interval')" />
            </div>

              <div>
                <x-primary-button>{{ __('Update') }}</x-primary-button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
