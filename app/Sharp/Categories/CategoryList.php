<?php

namespace App\Sharp\Categories;

use App\Models\Category;
use App\Sharp\Categories\Commands\CleanUnusedCategoriesCommand;
use Code16\Sharp\Show\Fields\Text;
use Code16\Sharp\Utils\Fields\FieldsContainer;
use Code16\Sharp\Show\Layout\ShowLayoutSection;
use Code16\Sharp\EntityList\SharpEntityList;
use Code16\Sharp\Utils\Filters\CheckFilter;
use Illuminate\Contracts\Support\Arrayable;

class CategoryList extends SharpEntityList
{
    use CategoryCommonTrait;

    public function buildListConfig(): void
    {
        $this->configureDefaultSort('posts_count', 'desc');
    }

    protected function getEntityCommands(): ?array
    {
        return [
            CleanUnusedCategoriesCommand::class,
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            new class extends CheckFilter
            {
                public function buildFilterConfig(): void
                {
                    $this->configureKey('orphan')
                        ->configureLabel('Orphan categories only.');
                }
            },
        ];
    }

    public function getListData(): array|Arrayable
    {
        $categories = Category::withCount('posts')
            ->when(
                $this->queryParams->filterFor('orphan'),
                fn ($q) => $q->having('posts_count', 0)
            )

            // Handle sorting
            ->when(
                $this->queryParams->sortedBy() === 'name',
                fn ($q) => $q->orderBy('name', $this->queryParams->sortedDir()),
                fn ($q) => $q->orderBy('posts_count', $this->queryParams->sortedDir())
            );

        return $this->transform($categories->get());
    }

    // protected function buildListFields(FieldsContainer $fieldsContainer): void
    // {
    //     $fieldsContainer
    //     //->
    //         ->addField(
    //             Text::make('name')
    //                 ->setLabel('Name')
    //                 ->setSortable(),
    //         )
    //         ->addField(
    //             Text::make('posts_count')
    //                 ->setLabel('# posts')
    //                 ->setSortable(),
    //         );
    // }

    // protected function buildListLayout(ShowLayoutSection $fieldsLayout): void
    // {
    //     $fieldsLayout
    //         ->addColumn('name', 7)
    //         ->addColumn('posts_count', 5);
    // }
}
