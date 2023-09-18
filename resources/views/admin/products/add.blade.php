@extends('admin.main')

@section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên Sản Phẩm</label>
                        <input type="text" name="name" value="{{old('name')}}" class="form-control"  placeholder="Nhập tên sản phẩm">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Mô Tả</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Mô Tả Chi Tiết</label>
                <textarea name="detail" id="detail" class="form-control">{{ old('detail') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Giá</label>
                        <input type="number" name="price" value="{{ old('price') }}"  class="form-control" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Số lượng</label>
                        <input type="number" name="quantity" value="{{ old('quantity') }}"  class="form-control" >
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh Sản Phẩm</label>
                <input type="file"  class="form-control" id="upload">
                <div id="image_show" style="padding-top: 20px"></div>
                <input type="hidden" name="thumb" id="thumb">
            </div>

            <div class="form-group">
                <label for="menu">Cây Trồng</label>
                <select class="form-control" name="id_crop">
                    @foreach($crops as $crop)
                        <option value="{{$crop->id}}">{{$crop->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="menu">Danh Mục</label>
                <select class="form-control" name="menu_id">
                    @foreach($menus as $menu)
                        <option value="{{$menu->id}}">{{$menu->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
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
