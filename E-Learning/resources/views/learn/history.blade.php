<x-layout title="Score History - {{ $wordList->title }}">
    <div class="min-h-screen bg-darker">
        <div class="max-w-3xl mx-auto px-4 py-6 md:py-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 md:mb-8 space-y-4 sm:space-y-0">
                <h1 class="text-xl sm:text-2xl text-white font-bold mb-2 md:mb-0">
                    <span class="translate-text" data-en="Score History" data-nl="Scoregeschiedenis">Score History</span> - {{ $wordList->title }}
                </h1>
                <div class="flex space-x-3">
                    <a href="{{ route('lists.view', $wordList) }}" class="bg-primary text-white px-3 py-1.5 sm:px-4 sm:py-2 rounded hover:bg-blue-600 transition text-sm sm:text-base translate-text" data-en="Back to List" data-nl="Terug naar Lijst">
                        Back to List
                    </a>
                </div>
            </div>

            @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            @if($sessions->isEmpty())
            <div class="bg-lighter rounded-2xl p-4 text-center">
                <p class="text-white translate-text" data-en="No learning sessions yet" data-nl="Nog geen leersessies">No learning sessions yet</p>
            </div>
            @else
            <div class="bg-lighter rounded-2xl p-2 sm:p-4 overflow-x-auto">
                <div class="min-w-full">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-darker">
                                <th class="text-white text-left py-3 px-2 sm:px-4 translate-text" data-en="Date" data-nl="Datum">Date</th>
                                <th class="text-white text-left py-3 px-2 sm:px-4 translate-text" data-en="Score" data-nl="Score">Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessions as $session)
                            <tr class="border-b border-darker">
                                <td class="text-white py-3 px-2 sm:px-4">{{ $session->created_at->format('Y-m-d H:i') }}</td>
                                <td class="py-3 px-2 sm:px-4">
                                    <span class="{{ $session->percentage >= 70 ? 'text-green-500' : 'text-red-500' }} font-medium">
                                        {{ $session->score }}/{{ $session->total_words }} ({{ $session->percentage }}%)
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-layout>