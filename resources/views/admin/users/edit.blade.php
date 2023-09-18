@extends('admin.main')

@section('head')

    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('Sub_button')
    <a class="btn btn-success" href="<?php echo route('admin.users.list')?>">
        <i class="fa fa-arrow-left"></i> Quay về danh sách</a>
    <a class="btn btn-success" href="/admin/users/forgot/{{$users->id}}">
         Thay đổi mật khẩu <i class="fa fa-arrow-right"></i></a>

@endsection

@section('content')

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Username</label>
                        <input type="text" name="name" value="{{ $users->name }}" class="form-control"  placeholder="Nhập username ">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Email</label>
                        <input type="email" name="email" value="{{$users->email}}" class="form-control"  placeholder="Nhập email ">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Mobile</label>
                        <input type="number" name="mobile" value="{{$users->mobile}}" class="form-control"  placeholder="Nhập email ">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Birth</label>
                        <input type="date" name="birth" value="{{$users->birth}}" class="form-control"  placeholder="Nhập tuổi ">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Giới tính</label>
                        @if($users->sex == "Nam")
                            <select class="form-control m-l-0-ssm"name="sex" id="sex">
                                <option value="Nam" selected>Nam</option>
                                <option value="Nu">Nữ</option>
                                <option value="Khac">Khác</option>
                            </select>
                        @elseif($users->sex == "Nu")
                            <select class="form-control m-l-0-ssm"name="sex" id="sex">
                                <option value="Nam" >Nam</option>
                                <option value="Nu" selected>Nữ</option>
                                <option value="Khac">Khác</option>
                            </select>
                        @else
                            <select class="form-control m-l-0-ssm"name="sex" id="sex">
                                <option value="Nam" >Nam</option>
                                <option value="Nu">Nữ</option>
                                <option value="Khac" selected>Khác</option>
                            </select>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Address</label>
                        <input type="text" name="address" value="{{$users->address}}" class="form-control"  placeholder="Nhập địa chỉ ">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Chức vụ</label>
                @if($users->active == 1)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="exampleRadios1" value="1" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Admin
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="exampleRadios2" value="2">
                        <label class="form-check-label" for="exampleRadios2">
                            Quản lí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="exampleRadios3" value="3">
                        <label class="form-check-label" for="exampleRadios3">
                            Nhân viên
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="exampleRadios3" value="5">
                        <label class="form-check-label" for="exampleRadios3">
                            Nhân viên thực tập
                        </label>
                    </div>
                @elseif($users->active == 2)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="exampleRadios1" value="1" >
                        <label class="form-check-label" for="exampleRadios1">
                            Admin
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="exampleRadios2" value="2" checked>
                        <label class="form-check-label" for="exampleRadios2">
                            Quản lí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="exampleRadios3" value="3">
                        <label class="form-check-label" for="exampleRadios3">
                            Nhân viên
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="exampleRadios3" value="5">
                        <label class="form-check-label" for="exampleRadios3">
                            Nhân viên thực tập
                        </label>
                    </div>
                @else($users->active == 3)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="exampleRadios1" value="1" >
                        <label class="form-check-label" for="exampleRadios1">
                            Admin
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="exampleRadios2" value="2" >
                        <label class="form-check-label" for="exampleRadios2">
                            Quản lí
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="exampleRadios3" value="3" checked>
                        <label class="form-check-label" for="exampleRadios3">
                            Nhân viên
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="exampleRadios3" value="5">
                        <label class="form-check-label" for="exampleRadios3">
                            Nhân viên thực tập
                        </label>
                    </div>
                @endif
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Sửa Tài Khoản</button>
        </div>
        @csrf
    </form>
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
