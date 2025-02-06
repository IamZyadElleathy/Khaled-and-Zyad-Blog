<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    // import with file uploding class from livewire
    use WithFileUploads;
    // define the fields in order to perform model binding using livewire..
    public $post_title = '';
    public $content = '';
    public $photo;

    // function to save post
    public function save(){
        $this->validate([
            'post_title' => 'required',
            'content' => 'required',
            'photo' => 'nullable',
        ]);
        
        $createPost = new Post;
        $createPost->post_title = $this->post_title;
        $createPost->content = $this->content;
        $createPost->user_id = auth()->user()->id;
        
        if ($this->photo) {
            $photo_name = md5($this->photo . microtime()).'.'.$this->photo->extension();
            $this->photo->storeAs('public/images', $photo_name);
            $createPost->photo = $photo_name;
        } else {
            $createPost->photo = 'default-post-image.jpg'; // You can set a default image here
        }
        
        $createPost->save();

        $this->post_title = '';
        $this->content = '';
        session()->flash('message', 'The post was successfully created!');
        $this->redirect('/my/posts',navigate: true);
    }
    public function render()
    {
        return view('livewire.create-post');
    }
}
