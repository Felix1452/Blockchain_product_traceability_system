@extends('admin.main')

@section('head')
@endsection

@section('content')

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Username</label>
                        <input type="text" name="name" value="{{old('name')}}" class="form-control"  placeholder="Nhập username ">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Email</label>
                        <input type="email" name="email" value="{{old('email')}}" class="form-control"  placeholder="Nhập email ">
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Mobile</label>
                        <input type="number" name="mobile" value="{{old('mobile')}}" class="form-control"  placeholder="Nhập số điện thoại ">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Giới tính</label>
                        <select class="form-control m-l-0-ssm"name="sex" id="sex">
                            <option value="Nam">Nam</option>
                            <option value="Nu">Nữ</option>
                            <option value="Khac">Khác</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Năm sinh</label>
                        <input type="date" name="birth" value="{{old('birth')}}" class="form-control"  placeholder="Nhập năm sinh">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Địa chỉ</label>
                        <input type="text" name="address" value="{{old('address')}}" class="form-control"  placeholder="Nhập địa chỉ">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Password</label>
                        <input type="password" name="password" value="{{old('password')}}" class="form-control"  placeholder="Nhập password ">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Enter Password</label>
                        <input type="password" name="repass" value="{{old('repass')}}" class="form-control"  placeholder="Nhập lại password ">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Chức vụ</label>
                @if(session()->has('perr'))
                    @if(session()->get('perr') == 1)
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
                    @elseif(session()->get('perr') == 2)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="active" id="exampleRadios3" value="3" checked>
                            <label class="form-check-label" for="exampleRadios3">
                                Nhân viên
                            </label>
                        </div>
                    @endif
                @endif
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
        @csrf
    </form>
@endsection

@section('footer')
@endsection
