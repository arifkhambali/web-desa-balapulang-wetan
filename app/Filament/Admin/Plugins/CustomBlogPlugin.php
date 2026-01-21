<?php

namespace App\Filament\Admin\Plugins;

use Firefly\FilamentBlog\Blog as BaseBlog;
use Filament\Panel;
use Firefly\FilamentBlog\Resources;

class CustomBlogPlugin extends BaseBlog
{
    public static function make(): static
    {
        return new static();
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            Resources\CategoryResource::class,
            Resources\PostResource::class,
            Resources\TagResource::class,
            Resources\SeoDetailResource::class,
        ]);
    }
}
