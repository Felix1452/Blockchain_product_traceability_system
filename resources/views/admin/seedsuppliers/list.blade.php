@extends('admin.main')

@section('content')

    <table class="table table-light-sm">
        <thead style="font-size: 18px; font-style: italic">
        <tr>
            <th width="5%">STT</th>
            <th width="15%">Mã doanh nghiệp</th>
            <th width="10%">Tên Cơ Sở</th>
            <th width="15%">Người Đại Diện</th>
            <th width="10%">Địa Chỉ</th>
            <th width="10%">Số Điện Thoại</th>
            <th width="20%">Ảnh</th>
            <th width="20%">Cập nhật</th>
            <th width="5%">&nbsp</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        {{--        {!! \App\Helpers\Helper::menu($menus) !!}--}}
        @foreach($seedsuppliers as $key => $seedsupplier)
            <tr>
                <td>{{$i}}</td>
                <td>{{$seedsupplier->madoanhnghiep}}</td>
                <td>{{$seedsupplier->tencoso}}</td>
                <td>{{$seedsupplier->nguoidaidienphaply}}</td>
                <td>{{$seedsupplier->diachi}}</td>
                <td>{{$seedsupplier->sodienthoai}}</td>
                <td><img width="150px" src="{{$seedsupplier->thumb}}" alt="Ảnh"> </td>
                <td>
                    <a style="margin-right: 5px" class="button btn-outline-warning btn-sm" href="/admin/seedsuppliers/edit/{{$seedsupplier->id}} ">
                        <i class="fa fa-edit"></i> <i>Edit</i>
                    </a>
                    <a class="button btn-outline-danger btn-sm" href="#"
                       onclick="removeRow({{$seedsupplier->id}}, '/admin/seedsuppliers/destroy')">
                        <i class="fa fa-trash"></i> <i>Delete</i>
                    </a>
                </td>
            </tr>
            <?php $i++ ?>
        @endforeach
        </tbody>
    </table>
@endsection


