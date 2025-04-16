<x-layout title="{{ $wordList->title }}">
    <div class="min-h-screen bg-darker">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center px-4 sm:px-8 lg:px-16 xl:px-32 py-4 md:py-8">
            <h1 class="text-xl sm:text-2xl text-white font-bold mb-2 md:mb-0">{{ $wordList->title }}</h1>
            <div class="flex flex-col sm:flex-row items-start sm:items-center">
                <span class="text-white mb-2 sm:mb-0">{{ $wordPairs->count() }} <span class="translate-text" data-en="words" data-nl="woorden">woorden</span></span>
                <a href="{{ route('lists.index') }}" class="bg-primary text-white px-3 py-1 sm:px-4 sm:py-2 rounded sm:ml-4 text-sm sm:text-base transition translate-text" data-en="Back to Lists" data-nl="Terug naar Lijsten">
                    Back to Lists
                </a>
            </div>
        </div>

        <div class="px-4 sm:px-8 lg:px-16 xl:px-32 space-y-4">
            <div class="flex flex-wrap gap-2 sm:gap-4 mb-4">
                <div class="relative group">
                    <a href="{{ route('learn', $wordList) }}" class="bg-green-500 text-white px-3 py-1 sm:px-4 sm:py-2 rounded hover:bg-green-600 transition text-sm sm:text-base translate-text" data-en="Learn words" data-nl="Woorden leren">Learn words</a>
                </div>

                @auth
                <div class="relative group">
                    <a href="{{ route('lists.history', $wordList) }}" class="bg-blue-500 text-white px-3 py-1 sm:px-4 sm:py-2 rounded hover:bg-blue-600 transition text-sm sm:text-base translate-text" data-en="Score History" data-nl="Scoregeschiedenis">Score History</a>
                </div>
                @endauth
            </div>

            <div class="bg-lighter rounded-2xl p-2 sm:p-4 overflow-x-auto">
                <div class="min-w-full">
                    @foreach($wordPairs as $pair)
                    <div class="flex items-center justify-between py-3 sm:py-4 border-b border-darker">
                        <div class="flex items-center w-1/2 pr-2">
                            <span class="text-white text-sm sm:text-base break-words">{{ $pair->original_word }}</span>
                        </div>
                        <div class="flex items-center w-1/2 pl-2">
                            <span class="text-white text-sm sm:text-base break-words">{{ $pair->translated_word }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layout>