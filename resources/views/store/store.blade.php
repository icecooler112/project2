@extends('layouts.app')

@section('content')

<div class="container">
  <h3 class="text-center">จัดการข้อมูลร้านค้า</h3>
  <div class="clearfix mb-2">
    <div class="float-left">
           <form method="GET" class="form-inline">
             <div class="form-group">
               <label for="limit" class="sr-only">Limit</label>
               <select class="form-control" id="limit" name="limit">
                 @php
                    $limits = [5,10,15,20];
                  @endphp
                  @for($i=0; $i < count($limits); $i++)
                  @php
                    $sel = $limits[$i] == $limit ? 'selected="1"' : '';
                  @endphp
                <option {{ $sel }} value="{{ $limits[$i] }}">{{ $limits[$i] }}</option>
                @endfor

                </select>
              </div>
               <div class="form-group">
                   <label for="search" class="sr-only">Search</label>
                   <input type="text" class="form-control" id="search" name="search" placeholder="ค้นหา ชื่อร้านค้า" value="{{ !empty($_GET['search']) ? $_GET['search'] : '' }}">
</div>
              <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> ค้นหา</button>
            </form>
        </div>
  <a href="{{ url('store/create') }}" class="btn btn-success float-right"><i class="fa fa-plus"></i> เพิ่มข้อมูลร้านค้า</a>

</div>
  <table class="table table-striped">
  <thead class="text-center">
    <tr>
      <th scope="col">ลำดับ</th>
      <th scope="col">รูปภาพ</th>
      <th scope="col">ชื่อร้านค้า</th>
      <th scope="col">ที่อยู่</th>
      <th scope="col">แก้ไขล่าสุด</th>
      <th scope="col">จัดการ</th>
    </tr>
  </thead>
  <tbody>
    @php
    $Number = 0;
    $start = 1;
    $end = $limit < count($data) ? $limit : count($data);
    @endphp
    @if( $data->currentPage() > 1)
      @php
      $Number = $limit * ($data->currentPage() - 1);
      $start = $limit * ($data->currentPage()-1) + 1;
      $end = $start + ($limit-1);
      @endphp

      @if( $end >= $data->total())
        @php
          $end = $data->total();
        @endphp
        @endif
      @endif
@foreach( $data as $key => $value )
    <tr>
      <th class="text-center">{{ $Number + $loop->iteration }}</th>
      <td class="text-center">
        @if( !empty($value->logo) )
        <img src="{{ asset('storage/'.$value->logo) }}" style="width: 80px; height: auto;">
        @else
        <img src="{{ asset('storage/images/1.jpg') }}" style="width: 80px; height: auto;">
        @endif
      </td>

      <td>{{ $value->name }}</td>
      <td class="text-center">{{ $value->address }}</td>
      <td class="text-center">{{ date('d-M-Y H:i:s', strtotime($value->updated_at)) }}</td>
      <td class="text-center">
        <a href="{{ action('StoreController@edit', $value->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i> แก้ไข</a>
        <a href="{{ action('StoreController@delete', $value->id) }}" onclick="return confirm('ลบ ?')" class="btn btn-danger"><i class="fa fa-trash"></i> ลบ</a>
      </td>
    </tr>
  @endforeach
  </tbody>
  <tfoot class="table table-striped">
    <tr>
    <th colspan="5"> แสดงข้อมูลจำนวน {{ $start }} ถึง {{ $end }} จาก {{ $data->total() }} รายการ
      <th>
      <div class="float-right">
          {{ $data->appends(request()->query())->links() }}
      </div>
    </th>
    </th>
    </tr>
  </tfoot>
</table>
</div>
@endsection
