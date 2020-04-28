<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel AS PM; //เรียก ProductModel มาใช้ใน Controller นี้


class ProductController extends Controller
{
  private $limit = 5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data = PM::paginate( $this->limit );
      return view('product')->with( ["data"=>$data, "limit"=>$this->limit] );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forms.formProduct');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = new PM;
      $data->name = $request->name;
      $data->detail = $request->detail;
      $data->price = $request->price;
      $data->save();


      return redirect()->route('product.index')->with('jsAlert', 'เพิ่มข้อมูลสำเร็จ');

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
      return view('forms.formProduct')->with( 'data',$data);
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
      $data = PM::findOrFail( $id );
      if( is_null($data) ){
        return back()->with('jsAlert', "ไม่พบข้อมูลที่ต้องการแก้ไข");
      }
      $data->name = $request->name;
      $data->detail = $request->detail;
      $data->price = $request->price;
      $data->update();
      return redirect()->route('product.index')->with('jsAlert', 'แก้ไขข้อมูลสำเร็จ');
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
      $data = PM::findOrFatil($id);
      if(is_null($data) ){
        return back()->with('jsAlert', "ไม่พบข้อมูล");
      }
      $data->delete();
      return back()->with('jsAlert', "ลบข้อมูลสำเร็จ");
    }
}
