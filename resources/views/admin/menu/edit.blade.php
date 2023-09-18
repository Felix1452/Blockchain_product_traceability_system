@extends('admin.main')

@section('head')
    <script src='/ckeditor/ckeditor.js'></script>
@endsection

@section('Sub_button')
    <a class="btn btn-success" href="/admin/menus/list"><i class="fa fa-arrow-left"></i> Quay về danh sách</a>
@endsection

@section('content')

    <form action="" method="POST" style="width: 90%; margin-left: auto; margin-right: auto">

        <div class="card-body">
            <div class="form-group">
                <label for="menu">Tên danh mục</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Nhập tên danh mục" value="{{$menus->name}}">
            </div>

            <div class="form-group">
                <label for="menu">Danh mục</label>
                <select class="form-control" name="parent_id">
                    <option value="0">Danh mục gốc </option>

                    @foreach($parent_id as $parent_menu)
                        @if($menus->id!=$parent_menu->id)
                            <option value="{{$parent_menu->id}}"
                                {{$parent_menu->id==$menus->parent_id ? 'selected': ''}}>
                                {{$parent_menu->name}}
                            </option>
                        @endif
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="menu">Mô tả</label>
                <textarea type="text" class="form-control" name="description" id="description" placeholder="Nhập mô tả" rows="3" cols="10" >{{$menus->description}}</textarea>
            </div>

            <div class="form-group">
                <label for="menu">Mô tả chi tiết</label>
                <textarea type="text" class="form-control"  name="content" id="content" >{{$menus->content}}</textarea>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh danh mục</label>
                <input type="file"  class="form-control" id="upload">
                <div id="image_show" style="padding-top: 20px">
                    <a href="{{$menus->thumb}}" target="_blank" >
                        <img onerror="this.onerror=null;this.src=\'/storage/uploads/404.jpg\';" style="border-radius: 5%; max-width: 30vmax; max-height: 30vmax" src="{{$menus->thumb}}">
                    </a>
                </div>
                <input type="hidden" name="thumb" id="thumb" value="{{$menus->thumb}}">
            </div>

            <div class="form-group">
                <label for="menu">Kích hoạt</label>
                <div class="custom-radio">
                    <input class="custom-control-radio" type="radio" value="1" name="active" id="active" {{$menus->active==1 ? 'checked =""' : ''}} >
                    <label for="active" class="custom-control-radio">Có </label>
                </div>
                <div class="custom-radio">
                    <input class="custom-control-radio" type="radio" value="0" name="active" id="noactive" {{$menus->active==0 ? 'checked =""' : ''}}>
                    <label for="noactive" class="custom-control-radio">Không </label>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-warning">SỬA DANH MỤC</button>
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
