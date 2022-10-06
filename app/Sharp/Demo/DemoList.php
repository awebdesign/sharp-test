<?php

namespace App\Sharp\Demo;

use Code16\Sharp\EntityList\Fields\EntityListField;
use Code16\Sharp\EntityList\Fields\EntityListFieldsContainer;
use Code16\Sharp\EntityList\Fields\EntityListFieldsLayout;
use Code16\Sharp\EntityList\SharpEntityList;
use Illuminate\Contracts\Support\Arrayable;
use Code16\Sharp\Show\Fields\SharpShowEntityListField;
use App\Models\Demo;

class DemoList extends SharpEntityList
{
    public function buildListConfig(): void
    {
        $this
        ->configureDefaultSort('name', 'ASC')
        ->configureSearchable()
        ->configurePaginated();
    }

    protected function buildListFields(EntityListFieldsContainer $fieldsContainer): void
    {
        $fieldsContainer
            ->addField(
                EntityListField::make('name')
                    ->setLabel('Name')
                    ->setSortable()
            )
            ->addField(
                EntityListField::make('prices')
                    ->setLabel('Prices')
                    ->setSortable()
            );
    }

    protected function buildListLayout(EntityListFieldsLayout $fieldsLayout): void
    {
        $fieldsLayout
            ->addColumn('name', 6)
            ->addColumn('prices', 6);
    }

    public function getListData(): array|Arrayable
    {
        $demo = Demo::query()
                ->orderBy($this->queryParams->sortedBy(), $this->queryParams->sortedDir());

        return $this
            ->setCustomTransformer("prices", function($value, Demo $demo) {
                return implode(', ', array_column($demo->prices->toArray(), 'price'));
            })
            ->transform($demo->paginate(20)
        );
    }
}
