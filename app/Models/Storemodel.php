<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Storemodel extends Model
{
  protected $table = "store";
  protected $fillable = [ "name", "address", "logo" ];
  public $primarykey = "id";

  public function lists($request){
    $query = DB::table( $this->table );
    if( !empty($request->search) ){
      $query->where('name','LIKE', "%{$request->search}%");
      $query->orwhere('address','LIKE', "%{$request->search}%");
    }
    return $query->paginate( $request->limit );
}
}
