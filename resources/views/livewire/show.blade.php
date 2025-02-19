@if($isOpen) 
    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
        
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
        
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                            <p class="border rounded w-full py-2 px-3 text-gray-700">{{ $title }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Body:</label>
                            <p class="border rounded w-full py-2 px-3 text-gray-700">{{ $body }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Image:</label>
                            @if($image)
                                <img src="{{ asset('storage/' . $image) }}" alt="Post Image" class="w-full rounded-lg shadow-md">
                            @else
                                <p class="text-gray-500">No Image</p>
                            @endif
                        </div>
                    </div>
                </div>
        
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-gray-700 shadow-sm hover:text-gray-500 sm:w-auto">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
