<?php

namespace App\Sharp\Demo;

use App\Models\Demo;
use App\Sharp\Utils\Filters\CategoryFilter;
use Code16\Sharp\Show\Fields\SharpShowEntityListField;
use Code16\Sharp\Show\Fields\SharpShowTextField;
use Code16\Sharp\Show\Layout\ShowLayout;
use Code16\Sharp\Show\Layout\ShowLayoutColumn;
use Code16\Sharp\Show\Layout\ShowLayoutSection;
use Code16\Sharp\Show\SharpShow;
use Code16\Sharp\Utils\Fields\FieldsContainer;

class DemoShow extends SharpShow
{
    public function buildShowConfig(): void
    {
        $this->configureBreadcrumbCustomLabelAttribute('name');
    }

    public function find(mixed $id): array
    {
        return $this->transform(Demo::findOrFail($id));
    }

    protected function buildShowFields(FieldsContainer $showFields): void
    {
        $showFields
            ->addField(SharpShowTextField::make('reference')->setLabel('Reference'))
            ->addField(SharpShowTextField::make('name')->setLabel('Name'))
            ->addField(SharpShowTextField::make('description')->setLabel('description'));
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
