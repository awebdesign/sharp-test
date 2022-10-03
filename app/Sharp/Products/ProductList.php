<?php

namespace App\Sharp\Products;

use Code16\Sharp\EntityList\Fields\EntityListField;
use Code16\Sharp\EntityList\Fields\EntityListFieldsContainer;
use Code16\Sharp\EntityList\Fields\EntityListFieldsLayout;
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

    protected function buildListFields(EntityListFieldsContainer $fieldsContainer): void
    {
        $fieldsContainer
            ->addField(
                EntityListField::make('reference')
                    ->setLabel('Ref.')
                    ->setSortable()
            )
            ->addField(
                EntityListField::make('name')
                    ->setLabel('Name')
                    ->setSortable()
            )
            ->addField(
                EntityListField::make('price')
                    ->setLabel('Price')
                    ->setSortable()
            );
    }

    protected function buildListLayout(EntityListFieldsLayout $fieldsLayout): void
    {
        $fieldsLayout
            ->addColumn('reference', 2)
            ->addColumn('name', 6)
            ->addColumn('price', 4);
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
