<?php

namespace App\Sharp\Categories;

use Code16\Sharp\Show\Fields\SharpShowTextField;
use Code16\Sharp\Show\Fields\SharpShowEntityListField;

trait CategoryCommonTrait {

    public function schema(string $type): array
    {
        return [
            SharpShowTextField::make('name')->setLabel('Name')->setSortable()->width(8),
            SharpShowTextField::make('posts_count')->setLabel('# posts')->setSortable()->width(4),
            SharpShowEntityListField::make('posts', 'posts')
                ->setLabel('Related posts')
                ->showCreateButton(false)
                ->showCount()
                ->hideFilterWithValue(CategoryFilter::class, function ($instanceId) {
                    return $instanceId;
                })->hideOnList(),
        ];
    }
}
