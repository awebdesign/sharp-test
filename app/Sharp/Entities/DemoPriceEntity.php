<?php

namespace App\Sharp\Entities;

use App\Sharp\Demo\DemoPriceList;
use App\Sharp\Demo\DemoPriceForm;
use Code16\Sharp\Utils\Entities\SharpEntity;

class DemoPriceEntity extends SharpEntity
{
    protected ?string $list = DemoPriceList::class;
    protected ?string $show = null;

    protected string $label = "Demo Price";
}
