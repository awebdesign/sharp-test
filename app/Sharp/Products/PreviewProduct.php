<?php

namespace App\Sharp\Products;
use App\Models\Product;
use Code16\Sharp\EntityList\Commands\InstanceCommand;

class PreviewProduct extends InstanceCommand
{
    public function label(): ?string
    {
        return 'Preview...';
    }

    public function execute(mixed $instanceId, array $data = []): array
    {
        return $this->view('sharp.product-preview', [
            'product' => Product::find($instanceId),
        ]);
    }
}
