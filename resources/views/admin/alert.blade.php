@if ($errors->any())
    <div class="alert alert-danger">
        <i>Thông báo lỗi</i>
        <ul>
            @foreach ($errors->all() as $error)
                <li><i>{{ $error }}</i></li>
            @endforeach
        </ul>
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger">
        <div>
            {{ Session::get('error') }}
        </div>
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success">
        <div>
            {{ Session::get('success') }}
        </div>
    </div>
@endif
