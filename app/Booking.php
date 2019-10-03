<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
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
  function Seller()
 {
   return $this->hasOne('App\SalesPerson', 'id', 'sellerId');
 }

 function latestCustomer()
 {
   return $this->hasOne('App\Customer', 'id', 'customerId');
 }

}
