<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Manage Posts - Laravel 11 Livewire CRUD with Jetstream & Tailwind CSS
    </h2>
</x-slot>

<div class="py-12">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                  <div class="flex">
                    <div>
                      <p class="text-sm">{{ session('message') }}</p>
                    </div>
                  </div>
                </div>
            @endif

            <div class="flex mb-3">
                <input type="text" wire:model="search" placeholder="Cari post..." 
                       class="border p-2 w-full rounded">
                <button wire:click="searchPost" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 ml-2 rounded">
                    Search
                </button>
                <button wire:click="resetSearch" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 ml-2 rounded">
                    Reset
                </button>
            </div>

            <button wire:click="create()" class="bg-green-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded my-3">Create New Post</button>

            @if($isOpen)
                @include('livewire.create')
            @endif

            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 w-20">No.</th>
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Body</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td class="border px-4 py-2">{{ $post->id }}</td>
                        <td class="border px-4 py-2">{{ $post->title }}</td>
                        <td class="border px-4 py-2">{{ $post->body }}</td>
                        <td class="border px-4 py-2 text-center">
                            <div class="flex justify-center space-x-2">
                                <button wire:click="show({{ $post->id }})" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 w-24 rounded">Show</button>
                                <button wire:click="edit({{ $post->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 w-24 rounded">Edit</button>
                                <button wire:click="delete({{ $post->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 w-24 rounded">Delete</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>