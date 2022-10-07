<?php

namespace App\Sharp\Categories;

use App\Models\Category;
use App\Sharp\Utils\Filters\CategoryFilter;
use Code16\Sharp\Show\Fields\EntityList;
use Code16\Sharp\Show\Fields\Text;
use Code16\Sharp\Show\Layout\ShowLayout;
use Code16\Sharp\Show\Layout\ShowLayoutColumn;
use Code16\Sharp\Show\Layout\ShowLayoutSection;
use Code16\Sharp\Show\SharpShow;
use Code16\Sharp\Utils\Fields\FieldsContainer;

class CategoryShow extends SharpShow
{
    use CategoryCommonTrait;

    public function buildShowConfig(): void
    {
        $this->configureBreadcrumbCustomLabelAttribute('name');
    }

    public function find(mixed $id): array
    {
        return $this->transform(Category::findOrFail($id));
    }

    // protected function buildShowFields(FieldsContainer $showFields): void
    // {
    //     $showFields
    //         ->addField(Text::make('name')->setLabel('Name'))
    //         ->addField(
    //             EntityList::make('posts', 'posts')
    //                 ->setLabel('Related posts')
    //                 ->showCreateButton(false)
    //                 ->showCount()
    //                 ->hideFilterWithValue(CategoryFilter::class, function ($instanceId) {
    //                     return $instanceId;
    //                 }),
    //         );
    // }

    // protected function buildShowLayout(ShowLayout $showLayout): void
    // {
    //     $showLayout
    //         ->addSection('', function (ShowLayoutSection $section) {
    //             $section
    //                 ->addColumn(6, function (ShowLayoutColumn $column) {
    //                     $column->withSingleField('name');
    //                 });
    //         })
    //         ->addEntityListSection('posts', collapsable: true);
    // }
}
