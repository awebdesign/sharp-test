<?php

namespace App\Sharp\Profile;

use Code16\Sharp\Show\Fields\Picture;
use Code16\Sharp\Show\Fields\Text;
use Code16\Sharp\Show\Layout\ShowLayout;
use Code16\Sharp\Show\Layout\ShowLayoutColumn;
use Code16\Sharp\Show\Layout\ShowLayoutSection;
use Code16\Sharp\Show\SharpSingleShow;
use Code16\Sharp\Utils\Fields\FieldsContainer;
use Code16\Sharp\Utils\Transformers\Attributes\Eloquent\SharpUploadModelThumbnailUrlTransformer;

class ProfileSingleShow extends SharpSingleShow
{
    protected function buildShowFields(FieldsContainer $showFields): void
    {
        $showFields
            ->addField(
                Text::make('name')
                    ->setLabel('Name'),
            )
            ->addField(
                Text::make('email')
                    ->setLabel('Email address'),
            )
            ->addField(
                Picture::make('avatar'),
            );
    }

    protected function buildShowLayout(ShowLayout $showLayout): void
    {
        $showLayout
            ->addSection('Informations', function (ShowLayoutSection $section) {
                $section
                    ->addColumn(6, function (ShowLayoutColumn $column) {
                        $column
                            ->withSingleField('name')
                            ->withSingleField('email');
                    })
                    ->addColumn(6, function (ShowLayoutColumn $column) {
                        $column
                            ->withSingleField('avatar');
                    });
            });
    }

    public function findSingle(): array
    {
        return $this
            ->setCustomTransformer('avatar', new SharpUploadModelThumbnailUrlTransformer(140))
            ->transform(auth()->user());
    }
}
