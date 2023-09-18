@extends('admin.main')

@section('content')

    <table class="table table-light-sm">
        <thead style="font-size: 18px; font-style: italic">
        <tr>
            <th width="5%">STT</th>
            <th width="15%">Mã Doanh Nghiệp</th>
            <th width="12%">Tên Cơ Sở</th>
            <th width="12%">Người Đại Diện</th>
            <th width="12%">Địa chỉ</th>
            <th width="11%">Số Điện Thoại</th>
            <th width="18%">Ảnh</th>
            <th width="15%">Cập nhật </th>
        </tr>
        </thead>
        <tbody>
                <?php $i = 1 ?>
                @foreach($salerooms as $key => $saleroom)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$saleroom->madoanhnghiep}}</td>
                        <td>{{$saleroom->tencoso}}</td>
                        <td>{{$saleroom->tennguoidaidien}}</td>
                        <td>{{$saleroom->diachi}}</td>
                        <td>{{$saleroom->sodienthoai}}</td>
                        <td><img width="150px" src="{{$saleroom->thumb_saleroom}}" alt="Ảnh"></td>
                        <td>
                            <a style="margin-right: 5px" class="button btn-outline-warning btn-sm" href="/admin/salerooms/edit/{{$saleroom->id}} ">
                                <i class="fa fa-edit"></i> <i>Edit</i>
                            </a>
                            <a class="button btn-outline-danger btn-sm" href="#"
                               onclick="removeRow({{$saleroom->id}}, '/admin/salerooms/destroy')">
                                <i class="fa fa-trash"></i> <i>Delete</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
        </tbody>
    </table>
@endsection


