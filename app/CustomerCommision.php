<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerCommision extends Model
{
  function Customer()
 {
   return $this->hasOne('App\Customer', 'id', 'customer_id');
 }
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
 function Companys()
 {
     return $this->hasOne('App\Company', 'id', 'company');
 }
}
