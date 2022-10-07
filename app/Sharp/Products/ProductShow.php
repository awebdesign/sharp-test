<?php

namespace App\Sharp\Products;

use App\Models\Product;
use App\Sharp\Utils\Filters\CategoryFilter;
use Code16\Sharp\Show\Fields\Text;
use Code16\Sharp\Show\Layout\ShowLayout;
use Code16\Sharp\Show\Layout\ShowLayoutColumn;
use Code16\Sharp\Show\Layout\ShowLayoutSection;
use Code16\Sharp\Show\SharpShow;
use Code16\Sharp\Utils\Fields\FieldsContainer;

class ProductShow extends SharpShow
{
    public function buildShowConfig(): void
    {
        $this->configureBreadcrumbCustomLabelAttribute('name');
    }

    public function find(mixed $id): array
    {
        return $this->transform(Product::findOrFail($id));
    }

    protected function buildShowFields(FieldsContainer $showFields): void
    {
        $showFields
            ->addField(Text::make('reference')->setLabel('Reference'))
            ->addField(Text::make('name')->setLabel('Name'))
            ->addField(Text::make('description')->setLabel('description'));
    }

    protected function buildShowLayout(ShowLayout $showLayout): void
    {
        $showLayout->addSection('', function (ShowLayoutSection $section) {
            $section
                ->addColumn(6, function (ShowLayoutColumn $column) {
                    $column
                        ->withSingleField('reference')
                        ->withSingleField('name')
                        ->withSingleField('description');
                });
        });

    }
}
