<?php

namespace App\Sharp\Entities;

use App\Sharp\Demo\DemoList;
use App\Sharp\Demo\DemoForm;
use App\Sharp\Demo\DemoShow;
use Code16\Sharp\Utils\Entities\SharpEntity;

class DemoEntity extends SharpEntity
{
    protected ?string $list = DemoList::class;
    protected ?string $form = DemoForm::class;
    protected ?string $show = DemoShow::class;

    protected string $label = "Demo";
}
