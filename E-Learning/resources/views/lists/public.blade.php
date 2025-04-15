<x-layout title="Public Word Lists">
    <div class="min-h-screen bg-darker">
        <div class="flex justify-between items-center mx-32 py-8">
            <h1 class="text-2xl text-white font-bold mb-4">Public Word Lists</h1>
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
                                <a href="{{ route('lists.edit', $list) }}" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-white text-center py-10">
                    <p>No public lists available yet.</p>
                </div>
            @endif
        </div>
    </div>
</x-layout>
