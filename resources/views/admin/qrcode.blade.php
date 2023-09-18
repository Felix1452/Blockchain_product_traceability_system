<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>How to Generate QR Code in Laravel 9</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>

<body>

    <div class="container mt-4">

    <div class="card">
        <div class="card-header">
            <h2>Simple QR Code</h2>
        </div>
        <div class="card-body">

{{--            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('https://techvblogs.com/blog/generate-qr-code-laravel-9')); !!}">--}}
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Color QR Code</h2>
        </div>
        <div class="card-body">
            <form action="#" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label for="menu">Tên danh mục</label>
                        <input value="{{old('name')}}" type="text" class="form-control" name="name" id="name" placeholder="Nhập tên danh mục">
                    </div>

                    <div class="form-group">
                        <label for="menu">Mô tả</label>
                        <textarea type="text" class="form-control" name="description" id="description" placeholder="Nhập mô tả" rows="3" cols="10" >{{old('description')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="menu">Mô tả chi tiết</label>
                        <textarea type="text" class="form-control" name="content" id="content" >{{old('content')}}</textarea>

                    </div>
                    <!-- /.card-body -->
                </div>

                @csrf
            </form>
            <div class="card-footer">
                <button onclick="btAnimation()" id="submit" class="btn btn-primary">TẠO DANH MỤC</button>
            </div>
        </div>
    </div>

</div>
</body>

<script>
    function btAnimation(){
        document.getElementById('submit').style.color = 'red'
        const myTimeout = setTimeout(a2, 5000);

    }
    function a2(){
        $name =  document.getElementById("name").value;
        alert($name);
    }
</script>
</html>
