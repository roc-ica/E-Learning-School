<x-layout title="lists">
    <div class="min-h-screen bg-darker">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mx-4 md:mx-8 lg:mx-32 py-6 md:py-8 space-y-4 sm:space-y-0">
            <h1 class="text-xl md:text-2xl text-white font-bold translate-text" data-en="Your Word Lists" data-nl="Jouw Woordenlijsten">Your Word Lists</h1>
            <a href="{{ route('lists.create') }}" class="bg-green-500 text-white px-4 py-2 rounded translate-text w-full sm:w-auto text-center" data-en="Create List" data-nl="Lijst Maken">
                Create List
            </a>
        </div>
        <div class="space-y-3 mx-4 md:mx-8 lg:mx-32">
            @foreach($wordLists as $list)
            <div class="flex items-center justify-between text-white bg-lighter p-4 md:p-5 rounded-2xl relative overflow-x-auto"
                x-data="{ open: false, hovering: false }"
                @mouseover="hovering = true"
                @mouseout="hovering = false">
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
                    <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 py-2 w-48 bg-darker rounded-md shadow-xl z-20">
                        <a href="{{ route('lists.edit', $list) }}" class="block px-4 py-2 text-sm text-white hover:bg-gray-700 translate-text" data-en="Edit" data-nl="Bewerken">
                            Edit
                        </a>
                        <form action="{{ route('lists.destroy', $list) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-white hover:bg-gray-700 translate-text" data-en="Remove" data-nl="Verwijderen" onclick="return confirm('Are you sure you want to delete this list?')">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-layout>