@extends('layouts.app')

@section('content')
<div class="container">
  <h3 class="text-center">{{ !empty($data->id) ? "แก้ไข" : "เพิ่ม" }}ข้อมูลสินค้า</h3>
  @if( !empty($data->id) )
  <form method="POST" action="{{ action('ProductController@update', $data->id) }}">
    <input type="hidden" name="_method" value="PUT">
  @else
  <form method="POST" action="{{ url('product') }}">
@endif

@csrf
  <div class="form-group">
    <label for="name">ชื่อสินค้า</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="ชื่อสินค้า" value="{{ !empty($data->name) ? $data->name: '' }}">
  </div>
  <div class="form-group">
    <label for="detail">รายละเอียด</label>
    <textarea type="text" class="form-control" id="detail" name="detail">{{ !empty($data->detail) ? $data->detail: '' }}</textarea>
  </div>
  <div class="form-group">
    <label for="price">ราคา</label>
    <input type="text" class="form-control" id="price" name="price" placeholder="ราคา" value="{{ !empty($data->price) ? $data->price: '' }}">
  </div>
  <div class="clearfix text-center">
  <button type="submit" class="btn btn-success">บันทึก</button>
  <button type="reset" class="btn btn-warning">ล้างค่า</button>
  <a href="{{ url('/product') }}" class="btn btn-danger">ยกเลิก</a>
</div>
</form>
</div>

@endsection
