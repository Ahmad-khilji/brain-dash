<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Theme extends Model
{
    use HasFactory, HasUuids,InteractsWithMedia;

    protected $fillable=['theme_name', 'start_date','end_date'];
}
