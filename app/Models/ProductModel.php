<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductModel extends Model
{
    protected $table = "product";
    protected $fillable = [ "name" , "detail" , "price" ];
    public $primarykey = "id";

    public function lists($request){
      $query = DB::table( $this->table );
      if( !empty($request->search) ){
        $query->where('name','LIKE', "%{$request->search}%");
        $query->orwhere('price','LIKE', "%{$request->search}%");
      }
      return $query->paginate( $request->limit );
    }
}
