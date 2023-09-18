@extends('admin.main')

@section('content')

    <table class="table table-light-sm">
        <thead style="font-size: 18px; font-style: italic">
        <tr>
            <th width="5%">STT</th>
            <th width="15%">Tên Cây Trồng</th>
            <th width="15%" >Mô Tả</th>
            <th width="15%">Ảnh</th>
            <th width="15%">Cây Giống</th>
            <th width="20%">Nhà Vườn</th>
            <th width="15%">Cập nhật </th>
        </tr>
        </thead>
        <tbody>
                <?php $i = 1 ?>
                @foreach($crops as $key => $crops)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$crops->name}}</td>
                        <td><div style="height:150px; overflow:hidden">{{$crops->description}}</div></td>
                        <td><img width="150px" src="{{$crops->thumb}}" alt="Ảnh"></td>
                        <td>{{$crops->name_seedsandseedling}}</td>
                        <td>{{$crops->name_farmer}}</td>
                        <td>
                            <a style="margin-right: 5px" class="button btn-outline-warning btn-sm" href="/admin/crops/edit/{{$crops->id}} ">
                                <i class="fa fa-edit"></i> <i>Edit</i>
                            </a>
                            <a class="button btn-outline-danger btn-sm" href="#"
                               onclick="removeRow({{$crops->id}}, '/admin/crops/destroy')">
                                <i class="fa fa-trash"></i> <i>Delete</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
        </tbody>
    </table>
@endsection


