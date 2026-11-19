<x-shop::layouts>
    <x-slot:title>
        @lang('shop::app.subscription.unsubscribe-success')
    </x-slot>

    <div class="container mx-auto px-4 py-16 text-center max-w-lg">
        <div class="p-8 bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
                Newsletter Unsubscribe
            </h1>

            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Are you sure you want to unsubscribe <strong>{{ $subscription->email }}</strong> from our newsletter?
            </p>

            <form action="{{ route('shop.subscription.destroy.post', $subscription->token) }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="primary-button bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded-lg transition-colors cursor-pointer"
                >
                    Confirm Unsubscribe
                </button>

                <a
                    href="{{ route('shop.home.index') }}"
                    class="secondary-button ml-3 inline-block font-medium py-2 px-6 rounded-lg transition-colors"
                >
                    Keep Subscription
                </a>
            </form>
        </div>
    </div>
</x-shop::layouts>
