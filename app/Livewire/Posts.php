<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class Posts extends Component
{
    use WithPagination, WithFileUploads;

    public $title, $body, $image, $post_id, $isShowMode = false, $oldImage;
    public $isOpen = false;
    public $search = '';

    protected $updatesQueryString = ['search'];

    public function render()
    {
        $posts = Post::where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('body', 'like', '%' . $this->search . '%')
                    ->orderBy('id', 'asc')
                    ->paginate(5);

        return view('livewire.posts', compact('posts'));
    }

    public function resetSearch()
    {
        $this->search = '';
        $this->resetPage(); 
    }

    public function searchPost()
    {
        $this->resetPage(); 
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->isShowMode = false;
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->body = '';
        $this->post_id = '';
        $this->image = null;
        $this->oldImage = null;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => $this->post_id ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);

        $imagePath = $this->oldImage;

        if ($this->image) {
            if ($this->post_id && $this->oldImage) {
                Storage::disk('public')->delete($this->oldImage);
            }
            $imagePath = $this->image->store('images', 'public');
        }

        Post::updateOrCreate(['id' => $this->post_id], [
            'title' => $this->title,
            'body' => $this->body,
            'image' => $imagePath
        ]);

        session()->flash('message', $this->post_id ? 'Post Updated Successfully.' : 'Post Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $id;
        $this->title = $post->title;
        $this->body = $post->body;
        $this->oldImage = $post->image;

        $this->openModal();
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        session()->flash('message', 'Post Deleted Successfully.');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $this->title = $post->title;
        $this->body = $post->body;
        $this->oldImage = $post->image;
        
        $this->isShowMode = true;
        $this->isOpen = true;
    }
}
