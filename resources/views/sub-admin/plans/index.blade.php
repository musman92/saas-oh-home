<x-sub-admin-app-layout>
  <x-slot name="header">
    <div class="flex justify-between">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Plans') }}
      </h2>
      <div class="ml-auto">
        <a href="{{ route('subadmin.plans.create') }}" class="bg-green-500 hover:bg-green-700 border rounded-md text-white font-bold py-2 px-4 rounded">Create New Plan</a>
      </div>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">#</th>
              <th scope="col" class="px-6 py-3">Plan Name</th>
              <th scope="col" class="px-6 py-3">Price</th>
              <th scope="col" class="px-6 py-3">Duration</th>
            </tr>
          </thead>
          <tbody>
            @foreach($plans as $plan)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
              <th scope="row" class="px-6 py-4">{{ $loop->iteration }}</th>
              <td class="px-6 py-4">{{ $plan->name }}</td>
              <td class="px-6 py-4">{{ $plan->amount }}</td>
              <td class="px-6 py-4">{{ $plan->interval }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
</x-sub-admin-app-layout>

