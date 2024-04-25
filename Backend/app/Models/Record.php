<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Record extends Model
{
    use HasFactory;

	const UPDATED_AT = null;

	protected $guarded = [];

	protected function video(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => ($value) ? env('APP_URL') . '/storage/videos/'. $value : '',
        );
    }
}
