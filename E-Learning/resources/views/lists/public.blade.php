<x-layout title="Public Word Lists">
    <div class="min-h-screen bg-darker">
        <div class="mx-4 md:mx-8 lg:mx-32 py-6 md:py-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
                <h1 class="text-xl md:text-2xl text-white font-bold translate-text" data-en="Public Word Lists" data-nl="Openbare Woordenlijsten">Public Word Lists</h1>
                <a href="{{ route('lists.index') }}" class="bg-primary text-white px-4 py-2 rounded translate-text w-full sm:w-auto text-center" data-en="My Lists" data-nl="Mijn Lijsten">
                    My Lists
                </a>
            </div>

            <!-- Search Form -->
            <div class="mb-8">
                <form action="{{ route('lists.public') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-grow">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="{{ __('Search by title or author...') }}"
                            class="w-full bg-lighter text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-primary text-white px-4 sm:px-6 py-3 rounded-lg hover:bg-blue-600 transition translate-text w-full sm:w-auto" data-en="Search" data-nl="Zoeken">
                            Search
                        </button>
                        @if(request()->has('search') && !empty(request('search')))
                        <a href="{{ route('lists.public') }}" class="bg-gray-600 text-white px-4 py-3 rounded-lg hover:bg-gray-700 transition translate-text w-full sm:w-auto text-center" data-en="Clear" data-nl="Wissen">
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
                    <span class="translate-text" data-en="Showing results for:" data-nl="Resultaten voor:">Showing results for:</span> "<span class="font-medium">{{ request('search') }}</span>"
                    <span class="ml-2 text-gray-400">({{ $publicLists->count() }} {{ Str::plural('result', $publicLists->count()) }})</span>
                </p>
            </div>
            @endif
        </div>

        <div class="space-y-3 mx-4 md:mx-8 lg:mx-32">
            @if($publicLists->count() > 0)
            @foreach($publicLists as $list)
            <div class="flex items-center justify-between text-white bg-lighter p-4 md:p-5 rounded-2xl relative overflow-x-auto"
                x-data="{ open: false, hovering: false }"
                @mouseover="hovering = true"
                @mouseout="hovering = false">
                <!-- Clickable area -->
                <a href="{{ route('lists.view', $list) }}" class="flex flex-grow justify-between items-center cursor-pointer flex-wrap md:flex-nowrap">
                    <div class="flex items-center w-full md:w-auto mb-2 md:mb-0">
                        <img src="{{ asset('images/english-flag.png') }}" alt="English Flag" class="w-5 h-5 md:w-7 md:h-7 mr-2 md:mr-4">
                        <span class="truncate max-w-[150px] sm:max-w-[200px] md:max-w-none">{{ $list->title }}</span>
                    </div>
                    <div class="text-sm md:text-base">{{ $list->author }}</div>
                    <div class="text-sm md:text-base">{{ $list->word_pairs_count }} <span class="translate-text" data-en="words" data-nl="woorden">words</span></div>
                </a>
                <!-- Dropdown menu -->
                <div class="relative ml-2 md:ml-4">
                    <button @click.stop="open = !open" class="flex text-white focus:outline-none"
                        :class="{ 'opacity-100': hovering || open, 'opacity-0': !(hovering || open) }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 py-2 w-48 bg-darker rounded-md shadow-xl z-20">
                        <a href="{{ route('learn', $list) }}" class="block px-4 py-2 text-sm text-white hover:bg-gray-700 translate-text" data-en="Learn Words" data-nl="Woorden Leren">
                            Learn Words
                        </a>
                        @if(auth()->check() && $list->user_id === auth()->id())
                        <a href="{{ route('lists.edit', $list) }}" class="block px-4 py-2 text-sm text-white hover:bg-gray-700 translate-text" data-en="Edit" data-nl="Bewerken">
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
                <p class="text-lg md:text-xl translate-text" data-en="No lists found matching" data-nl="Geen lijsten gevonden voor">No lists found matching "{{ request('search') }}".</p>
                <p class="mt-2 text-gray-400 translate-text" data-en="Try a different search term or browse all public lists." data-nl="Probeer een andere zoekterm of bekijk alle openbare lijsten.">Try a different search term or browse all public lists.</p>
                <div class="mt-4">
                    <a href="{{ route('lists.public') }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-600 transition translate-text" data-en="View All Lists" data-nl="Alle Lijsten Bekijken">
                        View All Lists
                    </a>
                </div>
                @else
                <p class="text-lg md:text-xl translate-text" data-en="No public lists available yet." data-nl="Er zijn nog geen openbare lijsten beschikbaar.">No public lists available yet.</p>
                @if(auth()->check())
                <p class="mt-2 text-gray-400 translate-text" data-en="Why not create a list and share it with others?" data-nl="Waarom maak je niet een lijst aan en deel je deze met anderen?">Why not create a list and share it with others?</p>
                <div class="mt-4">
                    <a href="{{ route('lists.create') }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-600 transition translate-text" data-en="Create List" data-nl="Lijst Maken">
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