<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Helpers\SEO;

class SeoMeta extends Component
{
    public $title;
    public $description;
    public $keywords;
    public $image;
    public $url;
    public $type;
    public $author;
    public $publishedTime;
    public $modifiedTime;
    
    public function __construct(
        $title = null,
        $description = null,
        $keywords = null,
        $image = null,
        $url = null,
        $type = 'website',
        $author = null,
        $publishedTime = null,
        $modifiedTime = null
    ) {
        $this->title = SEO::generateTitle($title);
        $this->description = $description ?? config('app.description', 'Sistem Informasi Desa');
        $this->keywords = $keywords;
        $this->image = SEO::generateImageUrl($image);
        $this->url = $url ?? url()->current();
        $this->type = $type;
        $this->author = $author;
        $this->publishedTime = $publishedTime;
        $this->modifiedTime = $modifiedTime;
    }
    
    public function render()
    {
        return view('components.seo-meta');
    }
}
