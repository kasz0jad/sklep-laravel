<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'price', 'stock', 'image', 'category'])]
class Product extends Model
{
    public const CATEGORIES = ['Kobieta', 'Mężczyzna', 'Dzieci', 'Dom', 'Akcesoria'];
}
