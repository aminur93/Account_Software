<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesIncome extends Model
{
  function saller_people()
 {
   return $this->hasOne('App\SalesPerson', 'id', 'sellerId');
 }
  function branch()
 {
   return $this->hasOne('App\Branch', 'id', 'branchId');
 }
  function category()
 {
   return $this->hasOne('App\Category', 'id', 'categoryId');
 }
  function subCategory()
 {
   return $this->hasOne('App\SubCategory', 'id', 'subcategoryId');
 }
  function Companys()
 {
   return $this->hasOne('App\Company', 'id', 'companyId');
 }

}
