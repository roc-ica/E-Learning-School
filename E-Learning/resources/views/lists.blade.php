<x-layout title="lists">
    <div class="min-h-screen bg-darker">
        <div class="flex justify-between items-center mx-32 py-8">
            <h1 class="text-2xl text-white font-bold mb-4">Your Word Lists</h1>
            <a href="{{ route('lists.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">
                Create List
            </a>
        </div>

        <div class="space-y-3 mx-32">
            @foreach($wordLists as $list)
                <div class="flex items-center justify-between text-white bg-lighter p-5 rounded-2xl">
                    <div class="flex items-center">
                        <img src="{{ asset('images/english-flag.png') }}" alt="English Flag" class="w-7 h-7 mr-4">
                        <span>{{ $list->title }}</span>
                    </div>
                    <div>{{ $list->author }}</div>
                    <div>{{ $list->words_count }} woorden</div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>
