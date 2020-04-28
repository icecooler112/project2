@extends('layouts.app')

@section('content')

<div class="container">
  <h3 class="text-center">จัดการข้อมูลสินค้า</h3>
  <div class="clearfix mb-2">
  <a href="{{ url('product/create') }}" class="btn btn-success float-right">เพิ่มข้อมูล</a>
</div>
  <table class="table table-striped">
  <thead class="text-center">
    <tr>
      <th scope="col">ลำดับ</th>
      <th scope="col">ชื่อสินค้า</th>
      <th scope="col">ราคา</th>
      <th scope="col">แก้ไขล่าสุด</th>
      <th scope="col">จัดการ</th>
    </tr>
  </thead>
  <tbody>
    @php
    $Number = 0;
    @endphp
    @if( $data->currentPage() > 1)
      @php
      $Number = $limit * ($data->currentPage() - 1);
      @endphp
      @endif
     @foreach( $data as $key => $value )
    <tr>
      <th class="text-center">{{ $Number + $loop->iteration }}</th>
      <td >{{ $value->name }}</td>
      <td class="text-center">{{ number_format($value->price) }} บาท</td>
      <td class="text-center">{{ $value->created_at }}</td>
      <td class="text-center">
        <a href="{{ action('ProductController@edit', $value->id) }}" class="btn btn-warning">แก้ไข</a>
        <a href="{{ action('ProductController@delete', $value->id) }}" onclick="return confirm('ลบ ?')" class="btn btn-danger">ลบ</a>
      </td>
    </tr>
    @endforeach
  </tbody>
  <tfoot class="table table-striped">
    <tr>
    <th colspan="5"> แสดงข้อมูลจำนวน  ถึง  จาก  รายการ</th>
    </tr>
  </tfoot>
</table>
<div class="float-right">
{{ $data->links() }}
</div>
</div>
@endsection
