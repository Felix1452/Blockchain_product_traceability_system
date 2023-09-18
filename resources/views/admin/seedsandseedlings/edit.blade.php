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
                        <label for="menu">Tên Hạt - Cây Giống</label>
                        <input type="text" name="name" value="{{ $seedsandseedling->name }}" class="form-control"  placeholder="Nhập Tên Hạt - Cây Giống">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Mô Tả</label>
                        <input type="text" name="description" value="{{ $seedsandseedling->description }}" class="form-control"  placeholder="Nhập mô tả">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Chi tiết</label>
                        <input type="text" name="detail" value="{{ $seedsandseedling->detail }}" class="form-control"  placeholder="Nhập chi tiết">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="menu">Nhà Cung Cấp Giống</label>
                <select class="form-control" name="id_seedsupplier">
                    @foreach($seedsuppliers as $seedsupplier)
                        @if($seedsupplier->id == $seedsandseedling->id_seedsupplier)
                            <option selected value="{{$seedsupplier->id}}">{{$seedsupplier->tencoso. " - " . $seedsupplier->madoanhnghiep}}</option>
                        @else
                            <option value="{{$seedsupplier->id}}">{{$seedsupplier->tencoso. " - " . $seedsupplier->madoanhnghiep}}</option>
                        @endif

                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh Nhà Vườn</label>
                <input type="file"  class="form-control" id="upload">
                <div id="image_show" style="padding-top: 20px">
                    <a href="{{$seedsandseedling->thumb}}" target="_blank" >
                        <img style="border-radius: 5%; max-width: 30vmax; max-height: 30vmax" src="{{$seedsandseedling->thumb}}">
                    </a>
                </div>
                <input type="hidden" name="thumb" id="thumb" value="{{$seedsandseedling->thumb}}">
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật Cây - Hạt Giống</button>
        </div>
        @csrf
    </form>
@endsection

@section('footer')
@endsection
