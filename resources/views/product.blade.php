@extends('layouts.app')

@section('content')

<div class="container">
  <h3 class="text-center">จัดการข้อมูลสินค้า</h3>
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
                  <label for="type"></label>
                  <select class="form-control" name="store" id="store">
                    <option value=""hidden>-เลือกร้านค้า-</option>
                    @foreach( $store AS $key => $value )
                      @php
                        $sel = '';
                      @endphp
                      @if( !empty($data->name) )
                          @if( $value->name == $data->name )
                            @php
                                $sel = 'selected="1"';
                            @endphp
                          @endif
                        @endif
                        @if( $value->name == old('name') )
                          @php
                            $sel = 'selected="1"';
                          @endphp
                        @endif
                    <option {{ $sel }} value="{{ $value->name }}">{{ $value->name }}</option>
                    @endforeach
                    </select>
                  </div>
              <div class="form-group">
                  <label for="type"></label>
                  <select class="form-control" name="type" id="type">
                    <option value=""hidden>-เลือกประเภทสินค้า-</option>
                    @foreach( $type AS $key => $value )
                      @php
                        $sel = '';
                      @endphp
                      @if( !empty($data->type) )
                          @if( $value->id == $data->type )
                            @php
                                $sel = 'selected="1"';
                            @endphp
                          @endif
                        @endif
                        @if( $value->id == old('type') )
                          @php
                            $sel = 'selected="1"';
                          @endphp
                        @endif
                    <option {{ $sel }} value="{{ $value->id }}">{{ $value->name }}</option>
                    @endforeach
                    </select>
                  </div>
               <div class="form-group">
                   <label for="search" class="sr-only">Search</label>
                   <input type="text" class="form-control" id="search" name="search" placeholder="ค้นหา ชื่อสินค้า" value="{{ !empty($_GET['search']) ? $_GET['search'] : '' }}">
</div>
              <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> ค้นหา</button>
            </form>
        </div>
  <a href="{{ url('product/create') }}" class="btn btn-success float-right"><i class="fa fa-plus"></i> เพิ่มข้อมูลสินค้า</a>

</div>
  <table class="table table-striped">
  <thead class="text-center">
    <tr>
      <th scope="col">ลำดับ</th>
      <th scope="col">รูปภาพ</th>
        <!-- <th scope="col">ประเภทสินค้า</th> -->
      <th scope="col">ชื่อสินค้า</th>
      <th scope="col">ราคา</th>
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
        @if( !empty($value->img) )
        <img src="{{ asset('storage/'.$value->img) }}" style="width: 80px; height: auto;">
        @else
        <img src="{{ asset('storage/images/1.jpg') }}" style="width: 80px; height: auto;">
        @endif
      </td>
      <!-- <td class="text-center">{{ $value->typename }}</td> -->
      <td>{{ $value->name }}</td>
      <td class="text-center">{{ number_format($value->price) }} บาท</td>
      <td class="text-center">{{ date('d-M-Y H:i:s', strtotime($value->updated_at)) }}</td>
      <td class="text-center">
        <a href="{{ action('ProductController@edit', $value->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i> แก้ไข</a>
        <a href="{{ action('ProductController@delete', $value->id) }}" onclick="return confirm('ลบ ?')" class="btn btn-danger"><i class="fa fa-trash"></i> ลบ</a>
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
