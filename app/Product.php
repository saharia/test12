<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        "quantity",
        "price",
        "description",
        "category_id",
    ];

    public function Category()
    {
      return $this->belongsTo('App\Category');
    }
}
