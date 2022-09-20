<?php

namespace App\Sharp\Posts;

use App\Models\Post;
use Code16\Sharp\EntityList\Commands\ReorderHandler;

class PostReorder implements ReorderHandler
{
    public function reorder(array $ids): void
    {
        Post::whereIn('id', $ids)
            ->get()
            ->each(function ($post) use ($ids) {
                $post->order = array_search($post->id, $ids) + 1;
                $post->save();
            });
    }
}
