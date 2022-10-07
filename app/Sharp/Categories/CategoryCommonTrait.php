<?php

namespace App\Sharp\Categories;

use Code16\Sharp\Show\Fields\Text;
use Code16\Sharp\Show\Fields\EntityList;

trait CategoryCommonTrait {

    public function schema(string $type): array
    {
        return [
            Text::make('name')->setLabel('Name')->setSortable()->width(8),
            Text::make('posts_count')->setLabel('# posts')->setSortable()->width(4),
            EntityList::make('posts', 'posts')
                ->setLabel('Related posts')
                ->showCreateButton(false)
                ->showCount()
                ->hideFilterWithValue(CategoryFilter::class, function ($instanceId) {
                    return $instanceId;
                })->hideOnList(),
        ];
    }
}
