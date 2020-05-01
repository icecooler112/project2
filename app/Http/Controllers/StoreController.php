<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Storemodel AS SM;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class StoreController extends Controller
{
  protected $cValidator = [
    'name' => 'required|min:3|max:255',
    'address' => 'required|min:2'
    ];

  protected $cValidatorMsg = [
    'name.required' => 'กรุณากรอกชื่อร้านค้า',
    'name.min' => 'ชื่อร้านค้าต้องมีอย่างน้อย 3 ตัวอักษร',
    'name.max' => 'ชื่อร้านค้าต้องมีไม่เกิน 255 ตัวอักษร',
    'address.required' => 'กรุณากรอกที่อยู่',
    'address.min' => 'ที่อยู่ร้านค้าต้องมีอย่างน้อย 3 ตัวอักษร'
  ];

   private $limit = 5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SM $pm)
    {
      $request->limit = !empty($request->limit) ? $request->limit : $this->limit;
      $data = $pm->lists( $request );
      return view('store.store')->with( ["data"=>$data, "limit"=>$request->limit] );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('store.forms.formStore');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validator = Validator::make( $request->all(), $this->cValidator, $this->cValidatorMsg);
      if( $validator->fails() ){
          return back()->withInput()->withErrors( $validator->errors() );
        }
        else{
        $data = new SM;
        $data->fill( Input::all() );
        if($data->save()){
          if($request->has('logo') ){
            $data->logo = $request->file('logo')->store('storeimg','public');
            $data->update();
          }
        }
        return redirect()->route('store.index')->with('jsAlert', 'เพิ่มข้อมูลสำเร็จ');
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
      $data = SM::findOrFail( $id );
      if( is_null($data) ){
        return back()->with('jsAlert', "ไม่พบข้อมูลที่ต้องการแก้ไข");
      }
      return view('store.forms.formStore')->with( ['data'=>$data , 'store'=>SM::get()] );
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
      $validator = Validator::make( $request->all(), $this->cValidator, $this->cValidatorMsg);
      if( $validator->fails() ){
            return back()->withInput()->withErrors( $validator->errors() );
        }
        else{
      $data = SM::findOrFail( $id );
      if( is_null($data) ){
        return back()->with('jsAlert', "ไม่พบข้อมูลที่ต้องการแก้ไข");
      }
        $data->fill( Input::all() );

      if( $data->update()) {
        if( $request->has('logo') ){

          if( !empty($data->logo) ){
            storage::disk('public')->delete( $data->logo );
          }

          $data->logo = $request->file('logo')->store('storeimg','public');
          $data->update();
        }
      }
      return redirect()->route('store.index')->with('jsAlert', 'แก้ไขข้อมูลสำเร็จ');
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
     $data = SM::findOrFail($id);
     if(is_null($data) ){
       return back()->with('jsAlert', "ไม่พบข้อมูล");
     }
     if( !empty($data->logo) ){
       storage::disk('public')->delete( $data->logo );
     }
     $data->delete();
     return back()->with('jsAlert', "ลบข้อมูลสำเร็จ");
   }
}
