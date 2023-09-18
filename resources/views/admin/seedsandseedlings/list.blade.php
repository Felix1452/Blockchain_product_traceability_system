@extends('admin.main')

@section('content')

    <table class="table table-light-sm">
        <thead style="font-size: 18px; font-style: italic">
        <tr>
            <th width="5%">STT</th>
            <th width="20%">Tên Hạt - Cây Giống</th>
            <th width="20%">Mô Tả</th>
            <th width="20%">Ảnh</th>
            <th width="20%">Nhà Cung Cấp</th>
            <th width="15%">Cập nhật </th>
        </tr>
        </thead>
        <tbody>
                <?php $i = 1 ?>
                @foreach($seedsandseedlings as $key => $seedsandseedling)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$seedsandseedling->name}}</td>
                        <td><div style="height:150px; overflow:hidden">{{$seedsandseedling->description}}</div>  </td>
                        <td><img width="150px" src="{{$seedsandseedling->thumb}}" alt="Ảnh"></td>
                        <td>{{$seedsandseedling->tencoso}}</td>
                        <td>
                            <a style="margin-right: 5px" class="button btn-outline-warning btn-sm" href="/admin/seedsandseedlings/edit/{{$seedsandseedling->id}} ">
                                <i class="fa fa-edit"></i> <i>Edit</i>
                            </a>
                            <a class="button btn-outline-danger btn-sm" href="#"
                               onclick="removeRow({{$seedsandseedling->id}}, '/admin/seedsandseedlings/destroy')">
                                <i class="fa fa-trash"></i> <i>Delete</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
        </tbody>
    </table>
@endsection


