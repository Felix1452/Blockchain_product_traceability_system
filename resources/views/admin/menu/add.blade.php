@extends('admin.main')

@section('head')
    <script src='/ckeditor/ckeditor.js' }}></script>
@endsection

@section('content')
    <form action="" method="POST" >

        <div class="card-body">
            <div class="form-group">
                <label for="menu">Tên danh mục</label>
                <input value="{{old('name')}}" type="text" class="form-control" name="name" id="name" placeholder="Nhập tên danh mục">
            </div>

            <div class="form-group">
                <label for="menu">Danh mục</label>
                <select class="form-control" name="parent_id">
                    <option value="0">Danh mục gốc </option>
                    @foreach($parent_id as $parent_menu)
                        <option value="{{$parent_menu->id}}">{{$parent_menu->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="menu">Mô tả</label>
                <textarea type="text" class="form-control" name="description" id="description" placeholder="Nhập mô tả" rows="3" cols="10" >{{old('description')}}</textarea>
            </div>

            <div class="form-group">
                <label for="menu">Mô tả chi tiết</label>
                <textarea type="text" class="form-control" name="content" id="content" >{{old('content')}}</textarea>

            </div>

            <div class="form-group">
                <label for="menu">Ảnh danh mục</label>
                <input type="file"  class="form-control" id="upload">
                <div id="image_show" style="padding-top: 20px"></div>
                <input type="hidden" name="thumb" id="thumb">
            </div>

            <div class="form-group">
                <label for="menu">Kích hoạt</label>
                <div class="custom-radio">
                    <input class="custom-control-radio" type="radio" value="1" name="active" id="active" checked="">
                    <label for="active" class="custom-control-radio">Có </label>
                </div>
                <div class="custom-radio">
                    <input class="custom-control-radio" type="radio" value="0" name="active" id="noactive">
                    <label for="noactive" class="custom-control-radio">Không </label>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">TẠO DANH MỤC</button>
        </div>
        @csrf
    </form>
@endsection

@section('footer')
    <script>
        ckeditor = CKEDITOR.replace('content', {
            language: 'vi',
            height: 400
        });
    </script>
@endsection
