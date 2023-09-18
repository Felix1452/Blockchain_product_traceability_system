@extends('admin.main')

@section('head')
@endsection
@include('admin.alert')

@section('content')

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="menu">Sản Phẩm</label>
                                <select onchange="getProductValue()" class="form-control" id="id_product" name="id_product">
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="menu">Số lượng (KG)</label>
                                <input type="number" name="quantity" id="quantity" value="{{old('shelf_life')}}" class="form-control"  placeholder="Nhập số lượng">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="menu">Ngày Hết Hạn</label>
                                <input type="datetime-local" id="shelf_life" name="shelf_life" value="{{old('shelf_life')}}" class="form-control"  placeholder="Nhập số lượng">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Chuỗi Siêu Thị</label>
                                @foreach($salerooms as $saleroom)
                                    <div class="form-check">
                                        <input class="form-check-input" id="saleroom" name="saleroom[]" type="checkbox" value="{{ $saleroom->id }}" id="{{ $saleroom->id }}">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            {{ $saleroom->tencoso }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Thông tin</label>
                        <table class="table table-striped">
                            <thead>
                            <tr class="table-active">
                                <th width="30%" scope="col">Thành viên</th>
                                <th width="40%">Tên cơ sở</th>
                                <th width="30%">ID</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th  scope="row">Nhà cung cấp giống</th>
                                <td id="nameNCC">{{ $firstProduct[0]->name_seed }}</td>
                                <td id="idNCC">{{ $firstProduct[0]->madoanhnghiep }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nhà Vườn</th>
                                <td id="nameNV">{{ $firstProduct[0]->tencoso }}</td>
                                <td id="idNV">{{ $firstProduct[0]->mavungtrong }}</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="align-content-center" scope="row"><img style="display: block;margin-left: auto;margin-right: auto;width: 40%;" width="150px" id="img_product" src="{{ $products[0]->thumb }}" alt="Ảnh"></th>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm Hóa Đơn Nhập hàng</button>
        </div>
        @csrf
    </form>
{{--    <div class="card-footer">--}}
{{--        <button onclick="btAnimation()" id="submit" name="submit" class="btn btn-primary">Thêm Hóa Đơn Nhập hàng</button>--}}
{{--    </div>--}}
@endsection

@section('footer')
@endsection
