<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel AS PM; //เรียก ProductModel มาใช้ใน Controller นี้
use App\Models\ProductTypeModel AS PTM; //เรียก ProductModel มาใช้ใน Controller นี้
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  protected $cValidator = [
    'type' => 'required',
    'name' => 'required|min:3|max:255',
    'detail' => 'required|min:2',
    'price' => 'required|numeric|digits_between:1,9'
  ];

  protected $cValidatorMsg = [
    'type.required' => 'กรุณาเลือกประเภทสินค้า',
    'name.required' => 'กรุณากรอกชื่อสินค้า',
    'name.min' => 'ชื่อสินค้าต้องมีอย่างน้อย 3 ตัวอักษร',
    'name.max' => 'ชื่อสินค้าต้องมีไม่เกิน 255 ตัวอักษร',
    'detail.required' => 'กรุณากรอกรายละเอียดสินค้า',
    'detail.min' => 'รายละเอียดสินค้าต้องมีอย่างน้อย 2 ตัวอักษร',
    'price.required' => 'กรุณากรอกราคาสินค้า',
    'price.numeric' => 'กรุณากรอกราคาสินค้าเป็นตัวเลข 0-9 เท่านั้น',
    'price.digits_between' => 'สามารถกรอกราคาสินค้าได้ตั้งแต่ 1 ตัวเลขขึ้นไป แต่ไม่เกิน 9 ตัวเลข'
  ];
  private $limit = 5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PM $pm)
    {
      $request->limit = !empty($request->limit) ? $request->limit : $this->limit;
      $data = $pm->lists( $request );
      return view('product')->with( ["data"=>$data, "limit"=>$request->limit, "type"=>PTM::get() ] );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forms.formProduct')->with( 'type', PTM::get() );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // $check = $request->validate([
      //   'name' => 'required|min:3|max:255',
      //   'detail' => 'required|min:5',
      //   'priะะะะะะะce' => 'required|numeric|digits_between:1,9'
      // ]);
      $validator = Validator::make( $request->all(), $this->cValidator, $this->cValidatorMsg);
      if( $validator->fails() ){
          return back()->withInput()->withErrors( $validator->errors() );
        }
        else{
        $data = new PM;
        $data->fill( Input::all() );
        if($data->save()){
          if($request->has('img') ){
            $data->img = $request->file('img')->store('photos','public');
            $data->update();
          }
        }
        return redirect()->route('product.index')->with('jsAlert', 'เพิ่มข้อมูลสำเร็จ');
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data = PM::findOrFail( $id );
      if( is_null($data) ){
        return back()->with('jsAlert', "ไม่พบข้อมูลที่ต้องการแก้ไข");
      }
      return view('forms.formProduct')->with( ['data'=>$data, 'type'=>PTM::get() ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      // $check = $request->validate([
      //   'name' => 'required|min:3|max:255',
      //   'detail' => 'required|min:5',
      //   'price' => 'required|numeric|digits_between:1,9'
      // ]);
      $validator = Validator::make( $request->all(), $this->cValidator, $this->cValidatorMsg);
      if( $validator->fails() ){
            return back()->withInput()->withErrors( $validator->errors() );
        }
        else{
      $data = PM::findOrFail( $id );
      if( is_null($data) ){
        return back()->with('jsAlert', "ไม่พบข้อมูลที่ต้องการแก้ไข");
      }
        $data->fill( Input::all() );
      // $data->name = $request->name;
      // $data->detail = $request->detail;
      // $data->price = $request->price;
      if( $data->update()) {
        if( $request->has('img') ){

          if( !empty($data->img) ){
            storage::disk('public')->delete( $data->img );
          }

          $data->img = $request->file('img')->store('photos','public');
          $data->update();
        }
      }
      return redirect()->route('product.index')->with('jsAlert', 'แก้ไขข้อมูลสำเร็จ');
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id){
     $data = PM::findOrFail($id);
     if(is_null($data) ){
       return back()->with('jsAlert', "ไม่พบข้อมูล");
     }
     if( !empty($data->img) ){
       storage::disk('public')->delete( $data->img );
     }
     $data->delete();
     return back()->with('jsAlert', "ลบข้อมูลสำเร็จ");
   }
}
