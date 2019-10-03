<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{

  protected $guarded = [];
    function Branch()
    {
        return $this->hasOne('App\Branch', 'id', 'branchId');
    }

    function category()
    {
        return $this->hasOne('App\Category', 'id', 'categoryId');
    }

    function subcategory()
    {
        return $this->hasOne('App\SubCategory', 'id', 'subcategoryId');
    }
    function Customer_relation()
    {
        return $this->hasOne('App\Customer', 'id', 'customerId');
    }
}
