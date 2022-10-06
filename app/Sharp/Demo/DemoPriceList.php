<?php

namespace App\Sharp\Demo;

use Code16\Sharp\EntityList\Fields\EntityListField;
use Code16\Sharp\EntityList\Fields\EntityListFieldsContainer;
use Code16\Sharp\EntityList\Fields\EntityListFieldsLayout;
use Code16\Sharp\EntityList\SharpEntityList;
use Illuminate\Contracts\Support\Arrayable;
use Code16\Sharp\Show\Fields\SharpShowEntityListField;
use App\Models\DemoPrice;
use Code16\Sharp\EntityList\Commands\ReorderHandler;

class DemoPriceList extends SharpEntityList
{
    public function buildListConfig(): void
    {
        $this
        ->configureDefaultSort('price', 'ASC')
        //->configureSearchable() => search field
        ->configurePaginated();

        // $this->configureMultiformAttribute('type')
        //     ->configureReorderable(new class implements ReorderHandler
        //     {
        //         public function reorder(array $ids): void
        //         {
        //             DemoPrice::whereIn('id', $ids)
        //                 ->get()
        //                 ->each(function (DemoPrice $price) use ($ids) {
        //                     $price->update(['demo' => array_search($price->id, $ids) + 1]);
        //                 });
        //         }
        //     });
    }

    protected function buildListFields(EntityListFieldsContainer $fieldsContainer): void
    {
        $fieldsContainer
            ->addField(
                EntityListField::make('price')
                    ->setLabel('Prices')
                    //->setSortable()
            );
    }

    protected function buildListLayout(EntityListFieldsLayout $fieldsLayout): void
    {
        $fieldsLayout
            ->addColumn('price', 6);
    }

    public function getListData(): array|Arrayable
    {
        $price = DemoPrice::orderBy('price')
        ->where('demo_id', $this->queryParams->filterFor('demo'))
        ->get();

        return $this
            ->transform($price);
    }
}
