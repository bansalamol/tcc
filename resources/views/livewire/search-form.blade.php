<form wire:submit.prevent="search" class="flex space-x-2">
    <input type="search" wire:model.defer="query" :placeholder="$attributes->get('placeholder')" class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Search</button>
</form>

