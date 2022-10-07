<?php

namespace App\Sharp\Demo;

use Code16\Sharp\Show\Fields\SharpShowTextField;
use Code16\Sharp\Utils\Fields\FieldsContainer;
use Code16\Sharp\Show\Layout\ShowLayoutSection;
use Code16\Sharp\EntityList\SharpEntityList;
use Illuminate\Contracts\Support\Arrayable;
use Code16\Sharp\Show\Fields\SharpShowSharpShowTextField;
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

    protected function buildListFields(FieldsContainer $fieldsContainer): void
    {
        $fieldsContainer
            ->addField(
                SharpShowTextField::make('name')
                    ->setLabel('Name')
                    ->setSortable()
                    ->width(6)
            )
            ->addField(
                SharpShowTextField::make('prices')
                    ->setLabel('Prices')
                    ->setSortable()
                    ->width(6)
            );
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
