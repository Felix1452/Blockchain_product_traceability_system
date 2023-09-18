@extends('admin.main')

@section('head')
@endsection

@section('content')

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Mã Doanh Nghiệp</label>
                        <input type="text" name="madoanhnghiep" value="{{$seedsuppliers->madoanhnghiep}}" class="form-control"  placeholder="Nhập tên cơ sở">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Tên Cơ Sở</label>
                        <input type="text" name="tencoso" value="{{$seedsuppliers->tencoso}}" class="form-control"  placeholder="Nhập tên cơ sở">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Chủ Cơ Sở</label>
                        <input type="text" name="chucoso" value="{{$seedsuppliers->chucoso}}" class="form-control"  placeholder="Nhập tên chủ cơ sở ">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Người Đại Diện Pháp Lý</label>
                        <input type="text" name="nguoidaidienphaply" value="{{$seedsuppliers->nguoidaidienphaply}}" class="form-control"  placeholder="Nhập tên người đại diện pháp lý">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Địa Chỉ</label>
                        <input type="text" name="diachi" value="{{$seedsuppliers->diachi}}" class="form-control"  placeholder="Nhập địa chỉ">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Số Điện Thoại</label>
                        <input type="number" name="sodienthoai" value="{{$seedsuppliers->sodienthoai}}" class="form-control"  placeholder="Nhập số điện thoại">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Mô Tả</label>
                        <input type="text" name="mota" value="{{$seedsuppliers->mota}}" class="form-control"  placeholder="Nhập mô tả">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh Nhà Vườn</label>
                <input type="file"  class="form-control" id="upload">
                <div id="image_show" style="padding-top: 20px">
                    <a href="{{$seedsuppliers->thumb}}" target="_blank" >
                        <img style="border-radius: 5%; max-width: 30vmax; max-height: 30vmax" src="{{$seedsuppliers->thumb}}">
                    </a>
                </div>
                <input type="hidden" name="thumb" id="thumb" value="{{$seedsuppliers->thumb}}">
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật Nhà Cung Cấp</button>
        </div>
        @csrf
    </form>
@endsection

@section('footer')
@endsection
