<x-layout title="Create New List">
    <div class="min-h-screen bg-darker">
        <div class="flex justify-between items-center mx-32 py-8">
            <h1 class="text-2xl text-white font-bold mb-4">Create new list</h1>
            <a href="{{ route('lists.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Create</a>
        </div>
        <div class="mx-32 mb-4">
            <input type="text" placeholder="Give your list a name" class="w-full bg-lighter text-white p-6 rounded-xl border-none placeholder-white" />
        </div>

        <div class="mx-32 mb-4 flex items-center" x-data="{ isVisible: false }">
            <div @click="isVisible = !isVisible"
                 :class="{'bg-green-500': isVisible, 'bg-lighter': !isVisible}"
                 class="w-10 h-6 flex items-center rounded-full p-1 cursor-pointer">
                <div :class="{'translate-x-4': isVisible}"
                     class="dot bg-white w-4 h-4 rounded-full shadow transform transition"></div>
            </div>
            <span class="text-white ml-3">Let others see this list</span>
        </div>

        <div class="space-y-4" x-data="{ words: Array.from({length: 4}, () => ({woord: '', vertaling: ''})) }">
            <template x-for="(word, index) in words" :key="index">
                <div class="flex items-center justify-between bg-lighter mx-32 p-5 rounded-2xl">
                    <div class="flex-grow">
                        <input type="text" placeholder="woord" x-model="word.woord" class="w-full bg-transparent border-none text-white placeholder-white">
                    </div>
                    <div class="flex-grow ml-4">
                        <input type="text" placeholder="vertaling" x-model="word.vertaling" class="w-full bg-transparent border-none text-white placeholder-white">
                    </div>
                    <button class="ml-4 text-white" @click="words.splice(index, 1)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
            <div class="flex items-center justify-center bg-primary mx-32 p-6 rounded-2xl cursor-pointer" @click="words.push({woord: '', vertaling: ''})">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="text-white ml-2">add row</span>
            </div>
        </div>
    </div>
</x-layout>
