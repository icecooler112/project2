@extends('layouts.app')

@section('content')
<div class="container">
  <h3 class="text-center">{{ !empty($data->id) ? "แก้ไข" : "เพิ่ม" }}ข้อมูลประเภทสินค้า</h3>
  <!-- @if (count($errors) > 0)
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
  @endif -->

  @if( !empty($data->id) )
  <form method="POST" action="{{ action('ProductTypeController@update', $data->id) }}" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
  @else
  <form method="POST" action="{{ url('producttype') }}" enctype="multipart/form-data">
@endif

@csrf
  <div class="form-group">
    <label for="name">ชื่อประเภทสินค้า</label>
    <input type="text" class="form-control {{ !empty($errors->first('name')) ? 'is-invalid' : '' }}" id="name" name="name" placeholder="ชื่อประเภทสินค้า" value="{{ !empty($data->name) ? $data->name: old('name') }}">
    @if( !empty($errors->first('name')) )
    <message class="text-danger">- {{ $errors->first('name') }}</message>
    @endif
  </div>

  <div class="clearfix text-center">
  <button type="submit" class="btn btn-success text-dark"><i class="fa fa-save"></i> บันทึก</button>
  <button type="reset" class="btn btn-warning"><i class="fa fa-undo"></i> ล้างค่า</button>
  <a href="{{ url('/producttype') }}" class="btn btn-danger text-dark"><i class="fa fa-chevron-circle-left"></i> ยกเลิก</a>
</div>
</form>
</div>

@endsection
