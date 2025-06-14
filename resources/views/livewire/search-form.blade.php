<form wire:submit.prevent="search" class="flex space-x-2">
    <input type="search" wire:model.defer="query" :placeholder="$attributes->get('placeholder')" class="w-full h-10 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
    <button type="submit" class="h-10 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-600">Search</button>
    <button type="button" wire:click="resetSearch" class="h-10 px-4 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Reset</button>
</form>

