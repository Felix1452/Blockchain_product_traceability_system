@extends('admin.main')

@section('content')

    <table class="table table-light-sm">
        <thead style="font-size: 18px; font-style: italic">
        <tr>
            <th width="5%">STT</th>
            <th width="15%">Mã Vùng Trồng</th>
            <th width="15%">Tên Cơ Sở</th>
            <th width="10%">Chủ Vườn</th>
            <th width="20%">Địa chỉ</th>
            <th width="20%">Ảnh</th>
            <th width="15%">Cập nhật </th>
        </tr>
        </thead>
        <tbody>
                <?php $i = 1 ?>
                @foreach($farmers as $key => $farmer)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$farmer->mavungtrong}}</td>
                        <td>{{$farmer->tencoso}}</td>
                        <td>{{$farmer->tenchunhatrong}}</td>
                        <td>{{$farmer->diachi}}</td>
                        <td><img width="150px" src="{{$farmer->thumb}}" alt="Ảnh"></td>
                        <td>
                            <a style="margin-right: 5px" class="button btn-outline-warning btn-sm" href="/admin/farmers/edit/{{$farmer->id}} ">
                                <i class="fa fa-edit"></i> <i>Edit</i>
                            </a>
                            <a class="button btn-outline-danger btn-sm" href="#"
                               onclick="removeRow({{$farmer->id}}, '/admin/farmers/destroy')">
                                <i class="fa fa-trash"></i> <i>Delete</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
        </tbody>
    </table>
@endsection


