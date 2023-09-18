@extends('admin.main')

@section('head')

    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('Sub_button')
    <a class="btn btn-success" href="<?php echo route('admin.users.list')?>">
        <i class="fa fa-arrow-left"></i> Quay về danh sách</a>
    <a class="btn btn-success" href="/admin/users/edit/{{$users->id}}">
        <i class="fa fa-arrow-left"></i> Quay về trước</a>
@endsection

@section('content')

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Mật khẩu hiện tại:</label>
                        <input required type="password" name="password" value="" class="form-control"  placeholder="Nhập mật khẩu hiện tại ">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Mật khẩu mới</label>
                        <input required type="password" name="repassword" value="" class="form-control"  placeholder="Nhập mật khẩu mới ">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Enter Password</label>
                        <input required type="password" name="repass2" value="" class="form-control"  placeholder="Nhập lại mật khẩu mới ">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thay đổi mật khẩu</button>
        </div>
        @csrf
    </form>
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
