@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">{{ __('Dashboard') }}</h2>
            </div>

            <div class="p-6">
                @if (session('status'))
                    <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 border border-green-300 rounded-md">
                        {{ session('status') }}
                    </div>
                @endif

                <p class="text-gray-700 mb-6">{{ __('You are logged in!') }}</p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('weddings.index') }}" class="inline-block bg-indigo-600 text-white font-semibold px-5 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Go to My Wedding
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto bg-red-600 text-white font-semibold px-5 py-2 rounded-lg hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
