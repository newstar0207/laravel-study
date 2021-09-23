<?php

namespace App\Http\Livewire;

use App\Models\Blog;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Livewire\Component;

class BlogComponent extends Component
{

    public $blog_title;
    public $slug;

    public function render()
    {
        // latest() => 날짜를 기반으로 결과를 정렬할 수 있게 함. 기본적으로 created_at 기준.
        // take() => 쿼리에서 반환되는 결과의 개수를 제한함
        $blogs = Blog::latest()->take(7)->get();
        return view('livewire.blog-component');
    }

    public function generateSlug()
    {
        $this->slug = SlugService::createSlug(Blog::class, 'slug', $this->blog_title);
    }

    public function store()
    {
        Blog::create([
            'blog_title' => $this->blog_title,
            'slug' => $this->slug,
        ]);
    }
}
