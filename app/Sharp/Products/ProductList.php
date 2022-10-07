<?php

namespace App\Sharp\Products;

use Code16\Sharp\Show\Fields\Text;
use Code16\Sharp\Utils\Fields\FieldsContainer;
use Code16\Sharp\Show\Layout\ShowLayoutSection;
use Code16\Sharp\EntityList\SharpEntityList;
use Illuminate\Contracts\Support\Arrayable;
use App\Models\Product;

class ProductList extends SharpEntityList
{
    public function __construct()
    {
    }

    protected function getInstanceCommands(): ?array
    {
        return [
            PreviewProduct::class,
            EditProduct::class
        ];
    }

    public function buildListConfig(): void
    {
        $this
        ->configureDefaultSort('reference', 'ASC')
        //->configureEntityState('state', PostStateHandler::class)

        ->configureSearchable()
        ->configurePaginated();
    }

    protected function buildListFields(FieldsContainer $fieldsContainer): void
    {
        $fieldsContainer
            ->addField(
                Text::make('reference')
                    ->setLabel('Ref.')
                    ->setSortable()
                    ->width(2)
            )
            ->addField(
                Text::make('name')
                    ->setLabel('Name')
                    ->setSortable()
                    ->width(6)
            )
            ->addField(
                Text::make('price')
                    ->setLabel('Price')
                    ->setSortable()
                    ->width(4)
            );
    }

    public function getListData(): array|Arrayable
    {
        $products = Product::query()
                ->orderBy($this->queryParams->sortedBy(), $this->queryParams->sortedDir());

        return $this
            ->setCustomTransformer('price', function ($value, $product) {
                return "€ " . number_format($value, 2);
            })
            ->transform($products->paginate(20)
        );
    }
}
