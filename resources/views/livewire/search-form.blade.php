<form wire:submit.prevent="search" class="flex space-x-2">
    <input type="search" wire:model.defer="query" :placeholder="$attributes->get('placeholder')" class="w-full h-10 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
    <x-button type="submit">Search</x-button>
    <x-secondary-button type="button" wire:click="resetSearch">Reset</x-secondary-button>
</form>

