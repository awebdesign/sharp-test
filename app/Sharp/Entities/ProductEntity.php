<?php

namespace App\Sharp\Entities;

use App\Sharp\Products\ProductList;
use App\Sharp\Products\ProductForm;
use App\Sharp\Products\ProductShow;
use Code16\Sharp\Utils\Entities\SharpEntity;

class ProductEntity extends SharpEntity
{
    protected ?string $list = ProductList::class;
    protected ?string $form = ProductForm::class;
    protected ?string $show = ProductShow::class;
}
