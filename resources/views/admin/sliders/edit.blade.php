@extends('admin.main')

@section('head')
@endsection

@section('content')

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Tên Slider</label>
                        <input type="text" name="name" value="{{$sliders->name}}" class="form-control"  placeholder="Nhập tên slider ">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Đường dẫn </label>
                        <input type="text" name="url" value="{{$sliders->url}}" class="form-control"  placeholder="Nhập đường dẫn ">
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label for="menu">Ảnh Slider</label>
                <input type="file"  class="form-control" id="upload">
                <div id="image_show" style="padding-top: 20px">
                    <a href="{{$sliders->thumb}}">
                        <img onerror="this.onerror=null;this.src=\'/storage/uploads/404.jpg\';" style="border-radius: 5%; max-width: 30vmax; max-height: 30vmax" src="{{$sliders->thumb}}">
                    </a>
                </div>
                <input type="hidden" name="thumb" value="{{$sliders->thumb}}" id="thumb">
            </div>

            <div class="form-group">
                <label for="menu">Sắp xếp</label>
                <input type="number" name="sort_by" value="{{$sliders->sort_by}}" class="form-control" style="width: 100px">
            </div>

            <div class="form-group">
                <label>Kích Hoạt</label>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="1" type="radio" id="active" name="active" {{$sliders->active==1 ? 'checked =""' : ''}}>
                    <label for="active" class="custom-control-label">Có</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="0" type="radio" id="no_active" name="active" {{$sliders->active==0 ? 'checked =""' : ''}}>
                    <label for="no_active" class="custom-control-label">Không</label>
                </div>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập nhật Slider</button>
        </div>
        @csrf
    </form>
@endsection

@section('footer')
@endsection
