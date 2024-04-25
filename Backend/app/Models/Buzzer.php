<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buzzer extends Model
{
    use HasFactory;

	protected $guarded = [];

	const UPDATED_AT = null;

	protected $hidden = [
		'is_read'
	];
}
