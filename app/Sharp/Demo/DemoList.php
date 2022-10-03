<?php

namespace App\Sharp\Demo;

use Code16\Sharp\EntityList\Fields\EntityListField;
use Code16\Sharp\EntityList\Fields\EntityListFieldsContainer;
use Code16\Sharp\EntityList\Fields\EntityListFieldsLayout;
use Code16\Sharp\EntityList\SharpEntityList;
use Illuminate\Contracts\Support\Arrayable;
use App\Models\Demo;

class DemoList extends SharpEntityList
{
    public function __construct()
    {
    }

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
            );
    }

    protected function buildListLayout(EntityListFieldsLayout $fieldsLayout): void
    {
        $fieldsLayout
            ->addColumn('name', 6);
    }

    public function getListData(): array|Arrayable
    {
        $demo = Demo::query()
                ->orderBy($this->queryParams->sortedBy(), $this->queryParams->sortedDir());

        return $this
            // ->setCustomTransformer("demprices", function($value, Demo $demo) {
            //     return $demo->motor === "EV" ? "electric" : "combustion";
            // })
            ->transform($demo->paginate(20)
        );
    }
}
