<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductModel extends Model
{
    protected $table = "product";
    protected $fillable = [ "name" , "detail" , "price", "type" ];
    public $primarykey = "id";

    public function lists($request){
      $query = DB::table( $this->table )
        ->select("{$this->table}.*", "product_type.name AS typename")
        ->leftjoin('product_type', "{$this->table}.type", "=", "product_type.id");

      if( !empty($request->search) ){
        $query->where(function($q) use ($request){
        $q->where('name','LIKE', "%{$request->search}%");
        $q->orwhere('price','LIKE', "%{$request->search}%");
      });
    }
      if( !empty($request->type) ){
        $query->where("{$this->table}.type", '=', $request->type);
      }
      return $query->paginate( $request->limit );
    }
}
