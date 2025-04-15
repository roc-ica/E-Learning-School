<x-layout title="{{ $wordList->title }}">
    <div class="min-h-screen bg-darker">
        <div class="flex justify-between items-center mx-32 py-8">
            <h1 class="text-2xl text-white font-bold mb-4">{{ $wordList->title }}</h1>
            <div>
                <span class="text-white">{{ $wordPairs->count() }} woorden</span>
                <a href="{{ route('lists.index') }}" class="bg-primary text-white px-4 py-2 rounded ml-4">
                    Back to Lists
                </a>
            </div>
        </div>

        <div class="mx-32 space-y-4">
            <div class="flex space-x-4 mb-4">
                <button class="bg-green-500 text-white px-4 py-2 rounded">Learn words</button>
            </div>

            <div class="bg-lighter rounded-2xl p-4">
                @foreach($wordPairs as $pair)
                    <div class="flex items-center justify-between py-4 border-b border-darker">
                        <div class="flex items-center">
                            <span class="text-white">{{ $pair->original_word }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-white">{{ $pair->translated_word }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>
