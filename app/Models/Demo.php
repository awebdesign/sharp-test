<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Translatable\HasTranslations;

class Demo extends Model
{
    use HasFactory; //, HasTranslations;

    protected $table = 'demo';

    protected $guarded = [];

    public function prices(): HasMany
    {
        return $this->hasMany(DemoPrice::class)
            ->orderBy('id');
    }
}
