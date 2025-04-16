<x-layout title="Edit Word List">
    <div class="min-h-screen bg-darker">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mx-4 md:mx-8 lg:mx-32 py-6 md:py-8 space-y-4 sm:space-y-0">
            <h1 class="text-xl md:text-2xl text-white font-bold translate-text" data-en="Edit list" data-nl="Lijst bewerken">Edit list</h1>
            <button type="submit" form="edit-list-form" class="bg-green-500 text-white px-4 py-2 rounded translate-text w-full sm:w-auto" data-en="Update List" data-nl="Lijst bijwerken">Update List</button>
        </div>
        <form id="edit-list-form" action="{{ route('lists.update', $wordList) }}" method="POST" class="space-y-4 mx-4 md:mx-8 lg:mx-32">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <input type="text" name="title" placeholder="{{ __('List Title') }}" required value="{{ $wordList->title }}"
                    class="w-full bg-lighter text-white p-4 md:p-6 rounded-xl border-none placeholder-white" />
            </div>
            <div class="space-y-4" x-data="{
                words: {{ json_encode($wordPairs->map(function($pair) {
                    return ['woord' => $pair->original_word, 'vertaling' => $pair->translated_word];
                })) }},
                wordsCount: {{ $wordPairs->count() }},
                isPublic: {{ $wordList->is_public ? 'true' : 'false' }}
            }">
                <div class="mb-4 flex items-center">
                    <div @click="isPublic = !isPublic"
                        :class="{'bg-green-500': isPublic, 'bg-lighter': !isPublic}"
                        class="w-10 h-6 flex items-center rounded-full p-1 cursor-pointer">
                        <div :class="{'translate-x-4': isPublic}"
                            class="bg-white w-4 h-4 rounded-full shadow transform transition"></div>
                    </div>
                    <span class="text-white ml-3 translate-text" data-en="Let others see this list" data-nl="Laat anderen deze lijst zien">Let others see this list</span>
                    <input type="hidden" name="is_public" :value="isPublic ? 1 : 0" />
                </div>

                <template x-for="(word, index) in words" :key="index">
                    <div class="flex flex-col sm:flex-row items-center justify-between bg-lighter p-4 md:p-5 rounded-2xl space-y-3 sm:space-y-0">
                        <div class="flex-grow w-full sm:w-auto">
                            <input type="text" :name="'words['+index+'][woord]'" x-model="word.woord" placeholder="{{ __('Word') }}" required
                                class="w-full bg-transparent border-none text-white placeholder-white" />
                        </div>
                        <div class="flex-grow ml-0 sm:ml-4 w-full sm:w-auto">
                            <input type="text" :name="'words['+index+'][vertaling]'" x-model="word.vertaling" placeholder="{{ __('Translation') }}" required
                                class="w-full bg-transparent border-none text-white placeholder-white" />
                        </div>
                        <button type="button" @click="words.splice(index, 1); wordsCount--" class="ml-0 sm:ml-4 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </template>

                <div class="flex items-center justify-center bg-primary p-4 md:p-6 rounded-2xl cursor-pointer"
                    @click="words.push({woord: '', vertaling: ''}); wordsCount++">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="text-white ml-2 translate-text" data-en="Add row" data-nl="Rij toevoegen">Add row</span>
                </div>
            </div>
            <input type="hidden" name="words_count" :value="wordsCount">
        </form>
    </div>
</x-layout>