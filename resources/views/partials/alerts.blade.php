@if (session('error'))
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-6">
    <div class="bg-red-500 text-white p-4 rounded">
      {{ session('error') }}
    </div>
  </div>
@endif
@if (session('success'))
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-6">
    <div class="bg-green-500 text-white p-4 rounded">
      {{ session('success') }}
    </div>
  </div>
@endif