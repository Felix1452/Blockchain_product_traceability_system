@extends('admin.main')

@section('content')

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card-body">

            <input type="hidden" name="product_id" id="product_id" value="{{$products->id}}">

            <div class="form-group">
                <label for="menu">Ảnh Sản Phẩm</label>
                <input type="file"  class="form-control" id="upload">
                <div id="image_show" style="padding-top: 20px"></div>
                <input type="hidden" name="thumb" id="thumb">
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm Ảnh</button>
        </div>
        @csrf
    </form>

    <table class="table table-light-sm">
        <thead style="font-size: 18px; font-style: italic">
        <tr>
            <th>ID</th>
            <th style="width: 30%">Tên sản phẩm </th>
            <th>Ảnh </th>
            <th>&nbsp</th>
        </tr>
        </thead>
        <tbody>
        @foreach($imgProduct as $key => $productsImg)

            <tr>
                <td>{{$productsImg->id}}</td>
                <td><a  href="{{$productsImg->thumb1}}" target="_blank"><img style="max-width: 25vmax; max-height: 15vmax" src="{{$productsImg->thumb1}}"></a></td>
                <td>
                    <a class="button btn-outline-danger btn-sm" href="#"
                       onclick="removeRow({{$productsImg->id}}, '/admin/products/destroyImg')">
                        <i class="fa fa-trash"></i> <i>Delete</i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
