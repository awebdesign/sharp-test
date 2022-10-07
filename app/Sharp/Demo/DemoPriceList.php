<?php

namespace App\Sharp\Demo;

use Code16\Sharp\Show\Fields\Text;
use Code16\Sharp\Utils\Fields\FieldsContainer;
use Code16\Sharp\Show\Layout\ShowLayoutSection;
use Code16\Sharp\EntityList\SharpEntityList;
use Illuminate\Contracts\Support\Arrayable;
use Code16\Sharp\Show\Fields\Text;
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

    protected function buildListFields(FieldsContainer $fieldsContainer): void
    {
        $fieldsContainer
            ->addField(
                Text::make('price')
                    ->setLabel('Prices')
                    //->setSortable()
            );
    }

    protected function buildListLayout(ShowLayoutSection $fieldsLayout): void
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
