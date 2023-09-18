@extends('admin.main')

@section('head')

    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('Sub_button')
    <a class="btn btn-success" href="/admin/products/list">
        <i class="fa fa-arrow-left"></i> Quay về danh sách</a>
    <a class="btn btn-primary" href="/admin/products/addimg/{{$product->id}} ">
        <i class="fa fa-image"></i> Thêm ảnh chi tiết
    </a>
@endsection

@section('content')

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên Sản Phẩm</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="form-control"  placeholder="Nhập tên sản phẩm">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Mô Tả</label>
                <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label>Chi Tiết</label>
                <textarea name="detail" id="detail" class="form-control">{{ $product->detail }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Giá</label>
                        <input type="number" name="price" value="{{ $product->price }}"  class="form-control" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Số lượng</label>
                        <input type="number" name="quantity" value="{{ $product->quantity }}"  class="form-control" >
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh Sản Phẩm</label>
                <input type="file"  class="form-control" id="upload">
                <div id="image_show" style="padding-top: 20px">
                    <a href="{{$product->thumb}}" target="_blank" >
                        <img style="border-radius: 5%; max-width: 30vmax; max-height: 30vmax" src="{{$product->thumb}}">
                    </a>
                </div>
                <input type="hidden" name="thumb" id="thumb" value="{{$product->thumb}}">
            </div>

            <div class="form-group">
                <label for="menu">Cây Trồng</label>
                <select class="form-control" name="id_crop">
                    @foreach($crops as $crop)
                        @if($crop->id == $product->id_crop)
                            <option selected value="{{$crop->id}}">{{$crop->name}}</option>
                        @else
                            <option value="{{$crop->id}}">{{$crop->name}}</option>
                        @endif

                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="menu">Danh Mục</label>
                <select class="form-control" name="menu_id">
                    @foreach($menus as $menu)
                        @if($menu->id == $product->menu_id)
                            <option selected value="{{$menu->id}}">{{$menu->name}}</option>
                        @else
                            <option value="{{$menu->id}}">{{$menu->name}}</option>
                        @endif

                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật Sản Phẩm</button>
        </div>
        @csrf
    </form>
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('detail',{
            height: '500px'
        });
    </script>
@endsection
