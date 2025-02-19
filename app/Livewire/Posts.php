<?php
  
namespace App\Livewire;
  
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;

class Posts extends Component
{
    use WithPagination;

    public $title, $body, $post_id;
    public $isOpen = false;
    public $search = ''; // Properti untuk pencarian

    protected $updatesQueryString = ['search']; // Menyimpan pencarian di URL

    public function render()
    {
        $posts = Post::where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('body', 'like', '%' . $this->search . '%')
                    ->orderBy('id', 'asc') // Ubah ke 'desc' jika ingin dari besar ke kecil
                    ->paginate(5); // Pakai pagination biar lebih rapi

        return view('livewire.posts', compact('posts'));
    }


    // public function updatingSearch()
    // {
    //     $this->resetPage(); // Reset pagination saat pencarian berubah
    // }
    public function resetSearch()
    {
        $this->search = ''; // Mengosongkan input pencarian
        $this->resetPage(); // Reset pagination ke halaman pertama
    }

    public function searchPost()
    {
        $this->resetPage(); // Reset pagination saat pencarian berubah
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
        $this->isShowMode = false; // Reset mode show
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->body = '';
        $this->post_id = '';
    }
     
    public function store()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
   
        Post::updateOrCreate(['id' => $this->post_id], [
            'title' => $this->title,
            'body' => $this->body
        ]);
  
        session()->flash('message', 
            $this->post_id ? 'Post Updated Successfully.' : 'Post Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $id;
        $this->title = $post->title;
        $this->body = $post->body;
    
        $this->openModal();
    }
     
    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Post Deleted Successfully.');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $this->title = $post->title;
        $this->body = $post->body;
        
        $this->isShowMode = true; // Mode show diaktifkan
        $this->isOpen = true; // Buka modal
    }
}
