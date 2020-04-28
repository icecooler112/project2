<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductModel extends Model
{
    protected $table = "product";
    protected $fillable = [ "name" , "detail" , "price" ];
    public $primarykey = "id";
}
