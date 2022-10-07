<?php

namespace App\Sharp\Authors;

use App\Models\User;
use App\Sharp\Authors\Commands\InviteUserCommand;
use App\Sharp\Authors\Commands\VisitFacebookProfileCommand;
use Code16\Sharp\Show\Fields\Text;
use Code16\Sharp\Utils\Fields\FieldsContainer;
use Code16\Sharp\Show\Layout\ShowLayoutSection;
use Code16\Sharp\EntityList\SharpEntityList;
use Code16\Sharp\Utils\Transformers\Attributes\Eloquent\SharpUploadModelThumbnailUrlTransformer;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;

class AuthorList extends SharpEntityList
{
    protected function buildListFields(FieldsContainer $fieldsContainer): void
    {
        $fieldsContainer
            ->addField(
                Text::make('avatar')
                    ->setLabel('')
                    ->width(1),
            )
            ->addField(
                Text::make('name')
                    ->setLabel('Name')
                    ->width(3)
                    ->setSortable(),
            )
            ->addField(
                Text::make('email')
                    ->setLabel('Email')
                    ->width(4)
                    ->setSortable(),
            )
            ->addField(
                Text::make('role')
                    ->width(4)
                    ->setLabel('Role'),
            );
    }

    // protected function buildListLayout(ShowLayoutSection $fieldsLayout): void
    // {
    //     $fieldsLayout
    //         ->addColumn('avatar', 1)
    //         ->addColumn('name', 3)
    //         ->addColumn('email', 4)
    //         ->addColumn('role', 4);
    // }

    // protected function buildListLayoutForSmallScreens(ShowLayoutSection $fieldsLayout): void
    // {
    //     $fieldsLayout
    //         ->addColumn('avatar', 2)
    //         ->addColumn('name', 5)
    //         ->addColumn('role', 5);
    // }

    public function buildListConfig(): void
    {
        $this->configureSearchable()
            ->configurePrimaryEntityCommand(InviteUserCommand::class)
            ->configureDefaultSort('name');
    }

    protected function getInstanceCommands(): ?array
    {
        return [
            VisitFacebookProfileCommand::class,
        ];
    }

    protected function getEntityCommands(): ?array
    {
        return [
            InviteUserCommand::class,
        ];
    }

    public function getListData(): array|Arrayable
    {
        $users = User::query()

            // Handle search words
            ->when(
                $this->queryParams->hasSearch(),
                function (Builder $builder) {
                    foreach ($this->queryParams->searchWords() as $word) {
                        $builder->where(function ($query) use ($word) {
                            $query
                                ->orWhere('name', 'like', $word)
                                ->orWhere('email', 'like', $word);
                        });
                    }
                },
            )

            // Handle sorting
            ->when(
                $this->queryParams->sortedBy() === 'email',
                function (Builder $builder) {
                    $builder->orderBy('email', $this->queryParams->sortedDir());
                },
                function (Builder $builder) {
                    $builder->orderBy('name', $this->queryParams->sortedDir() ?: 'asc');
                },
            );

        return $this
            ->setCustomTransformer('avatar', (new SharpUploadModelThumbnailUrlTransformer(100))->renderAsImageTag())
            ->setCustomTransformer('role', function ($value) {
                return match ($value) {
                    'admin' => 'Admin',
                    'editor' => 'Editor',
                    default => 'Unknown',
                };
            })
            ->transform($users->get());
    }
}
