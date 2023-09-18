@extends('admin.main')

@section('head')
@endsection
@include('admin.alert')

@section('content')

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Tên Cơ Sở</label>
                        <input type="text" name="tencoso" value="{{ $farmers->tencoso }}" class="form-control"  placeholder="Nhập tên cơ sở">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Mã Vùng Trồng</label>
                        <input type="text" name="mavungtrong" value="{{ $farmers->mavungtrong }}" class="form-control"  placeholder="Nhập mã doanh nghiệp">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Tên Chủ Vườn</label>
                        <input type="text" name="tenchunhatrong" value="{{ $farmers->tenchunhatrong }}" class="form-control"  placeholder="Nhập tên chủ cơ sở ">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Địa Chỉ</label>
                        <input type="text" name="diachi" value="{{ $farmers->diachi }}" class="form-control"  placeholder="Nhập địa chỉ">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Số Điện Thoại</label>
                        <input type="number" name="sodienthoai" value="{{ $farmers->sodienthoai }}" class="form-control"  placeholder="Nhập số điện thoại">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Mô Tả</label>
                        <input type="text" name="mota" value="{{ $farmers->mota }}" class="form-control"  placeholder="Nhập mô tả">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh Nhà Vườn</label>
                <input type="file"  class="form-control" id="upload">
                <div id="image_show" style="padding-top: 20px">
                    <a href="{{$farmers->thumb}}" target="_blank" >
                        <img style="border-radius: 5%; max-width: 30vmax; max-height: 30vmax" src="{{$farmers->thumb}}">
                    </a>
                </div>
                <input type="hidden" name="thumb" id="thumb" value="{{$farmers->thumb}}">
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật Nhà Vườn</button>
        </div>
        @csrf
    </form>
@endsection

@section('footer')
@endsection
