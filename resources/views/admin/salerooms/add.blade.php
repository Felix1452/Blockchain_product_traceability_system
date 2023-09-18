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
                        <input type="text" name="tencoso" id="tencoso" value="{{old('tencoso')}}" class="form-control"  placeholder="Nhập tên cơ sở">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Mã Doanh Nghiệp</label>
                        <input type="text" name="madoanhnghiep" id="madoanhnghiep" value="{{old('madoanhnghiep')}}" class="form-control"  placeholder="Nhập mã doanh nghiệp">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Chủ Cơ Sở</label>
                        <input type="text" name="tenchucoso" id="tenchucoso" value="{{old('tenchucoso')}}" class="form-control"  placeholder="Nhập tên chủ cơ sở ">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Nguời Đại Diện</label>
                        <input type="text" name="tennguoidaidien" id="tennguoidaidien" value="{{old('tennguoidaidien')}}" class="form-control"  placeholder="Nhập tên người đại diện ">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Địa Chỉ</label>
                        <input type="text" name="diachi" id="diachi" value="{{old('diachi')}}" class="form-control"  placeholder="Nhập địa chỉ">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Số Điện Thoại</label>
                        <input type="number" name="sodienthoai" id="sodienthoai" value="{{old('sodienthoai')}}" class="form-control"  placeholder="Nhập số điện thoại">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Mô Tả</label>
                        <input type="text" name="mota" id="mota" value="{{old('mota')}}" class="form-control"  placeholder="Nhập mô tả">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh Saleroom</label>
                <input type="file"  class="form-control" id="upload">
                <div id="image_show" style="padding-top: 20px"></div>
                <input type="hidden" name="thumb_saleroom" id="thumb">
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm Saleroom</button>
        </div>
        @csrf
    </form>

{{--    <div class="card-footer">--}}
{{--        <button onclick="btAnimationSaleroom()" id="submit" name="submit" class="btn btn-primary">Thêm Saleroom</button>--}}
{{--    </div>--}}
@endsection

@section('footer')
@endsection
