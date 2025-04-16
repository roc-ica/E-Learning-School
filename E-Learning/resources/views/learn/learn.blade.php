<x-layout title="Learn {{ $wordList->title }}">
    <div class="min-h-screen bg-darker" x-data="{
        wordPairs: {{ json_encode($wordPairs) }},
        userAnswers: Array({{ count($wordPairs) }}).fill(''),
        isChecked: Array({{ count($wordPairs) }}).fill(false),
        isCorrect: Array({{ count($wordPairs) }}).fill(false),
        score: 0,
        showScore: false,
        direction: '{{ $direction }}',
        submitScore() {
            document.getElementById('score-input').value = this.score;
            document.getElementById('total-words-input').value = this.wordPairs.length;
            document.getElementById('save-score-form').submit();
        },

        checkAnswer(index) {
            if (this.isChecked[index]) return;

            this.isChecked[index] = true;
            const correctAnswer = this.direction === 'normal'
                ? this.wordPairs[index].translated_word.toLowerCase().trim()
                : this.wordPairs[index].original_word.toLowerCase().trim();

            const isCorrect = this.userAnswers[index].toLowerCase().trim() === correctAnswer;
            this.isCorrect[index] = isCorrect;

            if (isCorrect) {
                this.score++;
            }
        },

        calculateScore() {
            return Math.round((this.score / this.wordPairs.length) * 100);
        },

        finishLearning() {
            // Check any remaining unchecked answers
            this.wordPairs.forEach((_, index) => {
                if (!this.isChecked[index]) {
                    this.checkAnswer(index);
                }
            });

            this.showScore = true;
        },

        getBorderColor(index) {
            if (!this.isChecked[index]) return 'border-gray-300';
            return this.isCorrect[index] ? 'border-green-500' : 'border-red-500';
        },

        getDisplayWord(pair) {
            return this.direction === 'normal' ? pair.original_word : pair.translated_word;
        },

        getExpectedAnswer(pair) {
            return this.direction === 'normal' ? pair.translated_word : pair.original_word;
        }
    }">
        <div class="max-w-3xl mx-auto px-4 py-6 md:py-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 md:mb-8 space-y-4 sm:space-y-0">
                <h1 class="text-xl md:text-2xl text-white font-bold translate-text" data-en="Learning:" data-nl="Leren:">Learning: {{ $wordList->title }}</h1>
                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                    <a href="{{ route('learn', ['wordList' => $wordList, 'direction' => $direction === 'normal' ? 'reversed' : 'normal']) }}"
                        class="bg-yellow-500 text-white px-3 py-2 rounded hover:bg-yellow-600 transition flex items-center justify-center translate-text w-full sm:w-auto" data-en="Switch Words" data-nl="Wissel Woorden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                        </svg>
                        Switch Words
                    </a>
                    <a href="{{ route('lists.view', $wordList) }}" class="bg-primary text-white px-4 py-2 rounded translate-text w-full sm:w-auto text-center" data-en="Back to List" data-nl="Terug naar Lijst">
                        Back to List
                    </a>
                </div>
            </div>

            <div class="bg-lighter rounded-2xl p-4 mb-6">
                <div class="mb-4">
                    <p class="text-white text-lg translate-text" data-en="Translate the following words:" data-nl="Vertaal de volgende woorden:">
                        {{ $direction === 'normal' ? 'Translate the following words:' : 'Provide the original words:' }}
                    </p>
                    <p class="text-gray-300 text-sm mt-1 translate-text" data-en="Enter the translations for each word" data-nl="Voer de vertalingen in voor elk woord">
                        {{ $direction === 'normal'
                            ? 'Enter the translations for each word'
                            : 'Enter the original words for each translation' }}
                    </p>
                </div>

                <div class="space-y-3">
                    <template x-for="(pair, index) in wordPairs" :key="index">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-2 border-b border-darker">
                            <div class="w-full sm:w-1/2 sm:pr-2 mb-2 sm:mb-0">
                                <span class="text-white text-base font-medium" x-text="getDisplayWord(pair)"></span>
                            </div>
                            <div class="w-full sm:w-1/2">
                                <input
                                    type="text"
                                    x-model="userAnswers[index]"
                                    @blur="checkAnswer(index)"
                                    :disabled="isChecked[index]"
                                    :class="getBorderColor(index)"
                                    class="w-full bg-darker text-white px-3 py-1.5 rounded border-2 focus:outline-none"
                                    placeholder="{{ __('Your answer...') }}">
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-6 flex justify-end">
                    <button
                        @click="finishLearning"
                        class="bg-primary text-white px-4 py-2 rounded font-medium hover:bg-blue-600 transition w-full sm:w-auto translate-text" data-en="Finish" data-nl="Voltooien">
                        Finish
                    </button>
                </div>
            </div>
        </div>

        <div
            x-show="showScore"
            x-cloak
            style="display: none"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div class="bg-lighter p-4 md:p-6 rounded-xl shadow-lg max-w-sm w-full">
                <h3 class="text-xl font-bold text-white mb-3 translate-text" data-en="Your Score" data-nl="Je Score">Your Score</h3>
                <div class="text-center py-4">
                    <div class="text-3xl md:text-4xl font-bold mb-2" :class="calculateScore() >= 70 ? 'text-green-500' : 'text-red-500'" x-text="calculateScore() + '%'"></div>
                    <p class="text-white text-sm md:text-base">
                        <span class="translate-text" data-en="You got" data-nl="Je hebt">You got</span> <span class="font-bold" x-text="score"></span> <span class="translate-text" data-en="out of" data-nl="van de">out of</span> <span x-text="wordPairs.length"></span> <span class="translate-text" data-en="correct" data-nl="goed">correct</span>
                    </p>
                </div>
                <div class="mt-4 flex flex-col sm:flex-row justify-between space-y-3 sm:space-y-0">
                    <a href="{{ route('lists.view', $wordList) }}" class="bg-gray-600 text-white px-3 py-1.5 rounded hover:bg-gray-700 transition translate-text w-full sm:w-auto text-center" data-en="Back to List" data-nl="Terug naar Lijst">
                        Back to List
                    </a>
                    <a :href="'{{ route('learn', ['wordList' => $wordList]) }}?direction=' + direction" class="bg-primary text-white px-3 py-1.5 rounded hover:bg-blue-600 transition translate-text w-full sm:w-auto text-center" data-en="Try Again" data-nl="Opnieuw Proberen">
                        Try Again
                    </a>
                </div>
                @auth
                <div class="mt-4 pt-4 border-t border-darker">
                    <button
                        @click="submitScore"
                        class="w-full bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded transition translate-text"
                        data-en="Save Score" data-nl="Score Opslaan">
                        Save Score
                    </button>
                    <form id="save-score-form" action="{{ route('learn.save-score', $wordList) }}" method="POST" class="hidden">
                        @csrf
                        <input type="hidden" name="score" id="score-input">
                        <input type="hidden" name="total_words" id="total-words-input">
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </div>
</x-layout>