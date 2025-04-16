<x-layout title="Learn {{ $wordList->title }}">
    <div class="min-h-screen bg-darker" x-data="{
        wordPairs: {{ json_encode($wordPairs) }},
        userAnswers: Array({{ count($wordPairs) }}).fill(''),
        isChecked: Array({{ count($wordPairs) }}).fill(false),
        isCorrect: Array({{ count($wordPairs) }}).fill(false),
        score: 0,
        showScore: false,
        
        checkAnswer(index) {
            if (this.isChecked[index]) return;
            
            this.isChecked[index] = true;
            const isCorrect = this.userAnswers[index].toLowerCase().trim() === this.wordPairs[index].translated_word.toLowerCase().trim();
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
        }
    }">
        <div class="max-w-3xl mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl text-white font-bold">Learning: {{ $wordList->title }}</h1>
                <a href="{{ route('lists.view', $wordList) }}" class="bg-primary text-white px-4 py-2 rounded">
                    Back to List
                </a>
            </div>

            <div class="bg-lighter rounded-2xl p-4 mb-6">
                <div class="mb-4">
                    <p class="text-white text-lg">Translate the following words:</p>
                </div>

                <div class="space-y-3">
                    <template x-for="(pair, index) in wordPairs" :key="index">
                        <div class="flex items-center justify-between py-2 border-b border-darker">
                            <div class="w-1/2 pr-2">
                                <span class="text-white text-base font-medium" x-text="pair.original_word"></span>
                            </div>
                            <div class="w-1/2">
                                <input
                                    type="text"
                                    x-model="userAnswers[index]"
                                    @blur="checkAnswer(index)"
                                    :disabled="isChecked[index]"
                                    :class="getBorderColor(index)"
                                    class="w-full bg-darker text-white px-3 py-1.5 rounded border-2 focus:outline-none"
                                    placeholder="Your translation...">
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-6 flex justify-end">
                    <button
                        @click="finishLearning"
                        class="bg-primary text-white px-4 py-2 rounded font-medium hover:bg-blue-600 transition">
                        Finish
                    </button>
                </div>
            </div>
        </div>

        <!-- Score Modal -->
        <div
            x-show="showScore"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            x-transition>
            <div class="bg-lighter p-6 rounded-xl shadow-lg max-w-sm w-full">
                <h3 class="text-xl font-bold text-white mb-3">Your Score</h3>
                <div class="text-center py-4">
                    <div class="text-4xl font-bold mb-2" :class="calculateScore() >= 70 ? 'text-green-500' : 'text-red-500'" x-text="calculateScore() + '%'"></div>
                    <p class="text-white">
                        You got <span class="font-bold" x-text="score"></span> out of <span x-text="wordPairs.length"></span> correct
                    </p>
                </div>
                <div class="mt-4 flex justify-between">
                    <a href="{{ route('lists.view', $wordList) }}" class="bg-gray-600 text-white px-3 py-1.5 rounded hover:bg-gray-700 transition">
                        Back to List
                    </a>
                    <a href="{{ route('learn', $wordList) }}" class="bg-primary text-white px-3 py-1.5 rounded hover:bg-blue-600 transition">
                        Try Again
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>