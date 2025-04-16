<x-layout title="Public Word Lists">
    <div class="min-h-screen bg-darker">
        <div class="mx-32 py-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl text-white font-bold">Public Word Lists</h1>
                <a href="{{ route('lists.index') }}" class="bg-primary text-white px-4 py-2 rounded">
                    My Lists
                </a>
            </div>

            <!-- Search Form -->
            <div class="mb-8">
                <form action="{{ route('lists.public') }}" method="GET" class="flex gap-4">
                    <div class="flex-grow">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search by title or author..."
                            class="w-full bg-lighter text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                            Search
                        </button>
                        @if(request()->has('search') && !empty(request('search')))
                        <a href="{{ route('lists.public') }}" class="bg-gray-600 text-white px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                            Clear
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Search Results Summary -->
            @if(request()->has('search') && !empty(request('search')))
            <div class="mb-4 text-white">
                <p>
                    Showing results for: "<span class="font-medium">{{ request('search') }}</span>"
                    <span class="ml-2 text-gray-400">({{ $publicLists->count() }} {{ Str::plural('result', $publicLists->count()) }})</span>
                </p>
            </div>
            @endif
        </div>

        <div class="space-y-3 mx-32">
            @if($publicLists->count() > 0)
            @foreach($publicLists as $list)
            <div class="flex items-center justify-between text-white bg-lighter p-5 rounded-2xl relative"
                x-data="{ open: false, hovering: false }"
                @mouseover="hovering = true"
                @mouseout="hovering = false">
                <!-- Clickable area -->
                <a href="{{ route('lists.view', $list) }}" class="flex flex-grow justify-between items-center cursor-pointer">
                    <div class="flex items-center">
                        <img src="{{ asset('images/english-flag.png') }}" alt="English Flag" class="w-7 h-7 mr-4">
                        <span>{{ $list->title }}</span>
                    </div>
                    <div>{{ $list->author }}</div>
                    <div>{{ $list->word_pairs_count }} woorden</div>
                </a>
                <!-- Dropdown menu -->
                <div class="relative ml-4">
                    <button @click.stop="open = !open" class="flex text-white focus:outline-none"
                        :class="{ 'opacity-100': hovering || open, 'opacity-0': !(hovering || open) }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 py-2 w-48 bg-darker rounded-md shadow-xl z-20">
                        <a href="{{ route('learn', $list) }}" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">
                            Learn Words
                        </a>
                        @if(auth()->check() && $list->user_id === auth()->id())
                        <a href="{{ route('lists.edit', $list) }}" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">
                            Edit
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="text-white text-center py-10 bg-lighter rounded-2xl">
                @if(request()->has('search') && !empty(request('search')))
                <p class="text-xl">No lists found matching "{{ request('search') }}".</p>
                <p class="mt-2 text-gray-400">Try a different search term or browse all public lists.</p>
                <div class="mt-4">
                    <a href="{{ route('lists.public') }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                        View All Lists
                    </a>
                </div>
                @else
                <p class="text-xl">No public lists available yet.</p>
                @if(auth()->check())
                <p class="mt-2 text-gray-400">Why not create a list and share it with others?</p>
                <div class="mt-4">
                    <a href="{{ route('lists.create') }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                        Create List
                    </a>
                </div>
                @endif
                @endif
            </div>
            @endif
        </div>
    </div>
</x-layout>