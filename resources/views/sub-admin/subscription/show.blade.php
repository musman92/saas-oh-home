<x-sub-admin-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          You will be charged <b>${{ number_format($plan->amount, 2) }}</b> for <b>{{ $plan->name }}</b> Plan

          <form id="payment-form" action="{{ route('subadmin.subs.create') }}" method="POST">
            @csrf
            <input type="hidden" name="plan" id="plan" value="{{ $plan->id }}">
            <div class="mb-4">
              <x-input-label for="card-holder-name" :value="__('Name')" />
              <x-text-input id="card-holder-name" name="name" type="text" 
                  class="mt-1 block w-full" 
                  :value="old('name')" 
                  required autofocus autocomplete="name" 
              />
              <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <div class="mb-4">
              <x-input-label for="name" :value="__('Card Detail')" />
              <div id="card-element"></div>
            </div>
            <div>
              <x-primary-button data-secret="{{ $intent->client_secret }}">{{ __('Submit') }}</x-primary-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        var form = document.getElementById('payment-form');
        const cardBtn = document.getElementById('card-button')
        const cardHolderName = document.getElementById('card-holder-name')

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            cardBtn.disabled = true

            const { setupIntent, error } = await stripe.confirmCardSetup(
              cardBtn.dataset.secret, {
                payment_method: {
                  card: card,
                  billing_details: {
                    name: cardHolderName.value
                  }
                }
              }
            );
            if(error) {
              cardBtn.disable = false
            } else {
              let token = document.createElement('input')
              token.setAttribute('type', 'hidden')
              token.setAttribute('name', 'token')
              token.setAttribute('value', setupIntent.payment_method)
              form.appendChild(token)
              form.submit();
            }
        });
    </script>
</x-sub-admin-app-layout>
