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
                        <input type="text" name="name" value="{{ $crop->name }}" class="form-control"  placeholder="Nhập Tên Hạt - Cây Giống">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Mô Tả</label>
                        <input type="text" name="description" value="{{ $crop->description }}" class="form-control"  placeholder="Nhập mô tả">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Chi tiết</label>
                        <input type="text" name="detail" value="{{ $crop->detail }}" class="form-control"  placeholder="Nhập chi tiết">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="menu">Hạt - Cây Giống</label>
                <select class="form-control" name="id_seedandseedling">
                    @foreach($seedsandseedlings as $seedsandseedling)
                        @if($seedsandseedling->id == $crop->id_seedandseedling)
                            <option selected value="{{$seedsandseedling->id}}">{{$seedsandseedling->name}}</option>
                        @else
                            <option value="{{$seedsandseedling->id}}">{{$seedsandseedling->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="menu">Nhà Vườn</label>
                <select class="form-control" name="id_farmer">
                    @foreach($farmers as $farmer)
                        @if($farmer->id == $crop->id_farmer)
                            <option selected value="{{$farmer->id}}">{{$farmer->tencoso ." - ".$farmer->mavungtrong}}</option>
                        @else
                            <option value="{{$farmer->id}}">{{$farmer->tencoso ." - ".$farmer->mavungtrong}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh Nhà Vườn</label>
                <input type="file"  class="form-control" id="upload">
                <div id="image_show" style="padding-top: 20px">
                    <a href="{{$crop->thumb}}" target="_blank" >
                        <img style="border-radius: 5%; max-width: 30vmax; max-height: 30vmax" src="{{$crop->thumb}}">
                    </a>
                </div>
                <input type="hidden" name="thumb" id="thumb" value="{{$crop->thumb}}">
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
