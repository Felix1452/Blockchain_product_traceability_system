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
                        <input type="text" name="tencoso" value="{{ $saleroom->tencoso }}" class="form-control"  placeholder="Nhập tên cơ sở">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Mã Doanh Nghiệp</label>
                        <input type="text" name="madoanhnghiep" value="{{ $saleroom->madoanhnghiep }}" class="form-control"  placeholder="Nhập mã doanh nghiệp">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Chủ Cơ Sở</label>
                        <input type="text" name="tenchucoso" value="{{ $saleroom->tenchucoso }}" class="form-control"  placeholder="Nhập tên chủ cơ sở ">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Nguời Đại Diện</label>
                        <input type="text" name="tennguoidaidien" value="{{ $saleroom->tennguoidaidien }}" class="form-control"  placeholder="Nhập tên người đại diện ">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Địa Chỉ</label>
                        <input type="text" name="diachi" value="{{ $saleroom->diachi }}" class="form-control"  placeholder="Nhập địa chỉ">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Số Điện Thoại</label>
                        <input type="number" name="sodienthoai" value="{{ $saleroom->sodienthoai }}" class="form-control"  placeholder="Nhập số điện thoại">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Mô Tả</label>
                        <input type="text" name="mota" value="{{ $saleroom->mota }}" class="form-control"  placeholder="Nhập mô tả">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh Saleroom</label>
                <input type="file"  class="form-control" id="upload">
                <div id="image_show" style="padding-top: 20px">
                    <a href="{{$saleroom->thumb_saleroom}}" target="_blank" >
                        <img style="border-radius: 5%; max-width: 30vmax; max-height: 30vmax" src="{{$saleroom->thumb_saleroom}}">
                    </a>
                </div>
                <input type="hidden" name="thumb_saleroom" id="thumb" value="{{$saleroom->thumb_saleroom}}">
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật Saleroom</button>
        </div>
        @csrf
    </form>
@endsection

@section('footer')
@endsection
