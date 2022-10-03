<?php

namespace App\Sharp\Products;
use App\Models\Product;
use Code16\Sharp\EntityList\Commands\InstanceCommand;

class EditProduct extends InstanceCommand
{
    public function label(): ?string
    {
        return 'Edit';
    }

    public function execute(mixed $instanceId, array $data = []): array
    {
        return $this->link("products/s-show/products/{$instanceId}/s-form/products/{$instanceId}?tab=content");
    }
}
