@extends('layouts.app')

@section('content')
<div class="container">
  <h3 class="text-center">{{ !empty($data->id) ? "แก้ไข" : "เพิ่ม" }}ข้อมูลสินค้า</h3>
  @if (count($errors) > 0)
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach($errors->all() as $error )
            <li> {{ $error }} </li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
  @endif

  @if( !empty($data->id) )
  <form method="POST" action="{{ action('ProductController@update', $data->id) }}" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
  @else
  <form method="POST" action="{{ url('product') }}" enctype="multipart/form-data">
@endif

@csrf
<div class="form-group">
    <label for="type">ประเภทสินค้า</label>
    <select class="form-control" id="type">
      <option >1</option>

    </select>
  </div>
  <div class="form-group">
    <label for="name">ชื่อสินค้า</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="ชื่อสินค้า" value="{{ !empty($data->name) ? $data->name: old('name') }}">
  </div>
  <div class="form-group">
    <label for="detail">รายละเอียด</label>
    <textarea type="text" class="form-control" id="detail" name="detail">{{ !empty($data->detail) ? $data->detail: old('detail') }}</textarea>
  </div>
  <div class="form-group">
    <label for="price">ราคา</label>
    <input type="text" class="form-control" id="price" name="price" placeholder="ราคา" value="{{ !empty($data->price) ? $data->price: old('price') }}">
  </div>
  <div class="form-group">
  <label for="img">รูปภาพ</label>
    <input type="file" class="form-control" id="img" name="img" accept="image/*">
  </div>
  @if( !empty($data->img) )
  <div class="text-center">
    <img scr="{{ asset('storage/'.$data->img) }}" width="250" height="250">
  </div>
  @endif
  <div class="clearfix text-center">
  <button type="submit" class="btn btn-success text-dark"><i class="fa fa-save"></i> บันทึก</button>
  <button type="reset" class="btn btn-warning"><i class="fa fa-undo"></i> ล้างค่า</button>
  <a href="{{ url('/product') }}" class="btn btn-danger text-dark"><i class="fa fa-chevron-circle-left"></i> ยกเลิก</a>
</div>
</form>
</div>

@endsection
