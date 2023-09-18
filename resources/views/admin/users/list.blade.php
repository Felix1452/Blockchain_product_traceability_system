@extends('admin.main')

@section('content')


    <table id="sortTable" class="table table-light-sm">
        <thead style="font-size: 18px; font-style: italic">
        <tr>
            <th>ID</th>
            <th style="width: 15%">Username</th>
            <th>Email</th>
            <th>Quyền hạn<a class="btn btn-light" onclick="sortTable()"><i class="fa fa-arrow-down"></i></a></th>
            <th>Số điện thoại</th>
            <th>Ngày vào làm</th>
            <th>Cập nhật </th>
            <th>&nbsp</th>
        </tr>
        </thead>
        <tbody>
        {{--        {!! \App\Helpers\Helper::menu($menus) !!}--}}
        @foreach($users as $key => $user)

            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    @if($user->perrmission == 1)
                        Admin
                    @elseif($user->perrmission == 2)
                        Quản lí
                    @elseif($user->perrmission == 3)
                        Nhân viên
                    @elseif($user->perrmission == 4)
                        Khách hàng
                    @else
                        Nhân viên thực tập
                    @endif
                </td>
                <td>{{$user->moblie}}</td>
                <td>{{$user->created_at}}</td>
                <td>
                    <a style="margin-right: 5px" class="button btn-outline-warning btn-sm" href="/admin/users/edit/{{$user->id}} ">
                        <i class="fa fa-edit"></i> <i>Edit</i>
                    </a>
                    <a class="button btn-outline-danger btn-sm" href="#"
                       onclick="removeRow({{$user->id}}, '/admin/users/destroy')">
                        <i class="fa fa-trash"></i> <i>Delete</i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('footer')
    <script>
        function sortTable() {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("sortTable");
            switching = true;
            /*Make a loop that will continue until
            no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("TD")[3];
                    y = rows[i + 1].getElementsByTagName("TD")[3];
                    //check if the two rows should switch place:
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }
    </script>
@endsection

