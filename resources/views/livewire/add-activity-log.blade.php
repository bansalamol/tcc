<div class="mb-4">
    <button wire:click="openModal" class="bg-black text-white px-2 py-1 rounded hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300">
        Add Comment
    </button>

     @if ($isOpen)
        <div class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: block;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Add Activity Log</h3>
                        <div class="mt-2">
                            <form wire:submit.prevent="saveActivityLog">
                                <input type="hidden" wire:model="appointmentId">
                                <div class="mb-2">
                                    <label for="activityType" class="block text-sm font-medium text-gray-700">Activity Type</label>
                                    <input wire:model="activityType" type="text" class="form-input mt-1 block w-full bg-gray-200 cursor-not-allowed" id="activityType" name="activityType" value="Comment" readonly>
                                </div>
                                <div class="mb-2">
                                    <label for="activityDescription" class="block text-sm font-medium text-gray-700">Comment</label>
                                    <textarea wire:model="activityDescription" class="form-input mt-1 block w-full" id="activityDescription" name="activityDescription" rows="4"></textarea>
                                </div>
                                <div class="mt-4 flex justify-between items-center">
                                    <button type="submit" class="bg-black text-white px-2 py-1 rounded hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('pageReload', function () {
            window.location.reload(); // Reload the page
        });
    });
</script>
