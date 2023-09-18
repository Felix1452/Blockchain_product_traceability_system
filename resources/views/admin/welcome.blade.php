<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
    </head>
    <body>
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
        <div class="card-footer">
            <button onclick="btAnimation()" id="submit" class="btn btn-primary">TẠO DANH MỤC</button>
        </div>
        @csrf
    </form>

    </body>


</html>
