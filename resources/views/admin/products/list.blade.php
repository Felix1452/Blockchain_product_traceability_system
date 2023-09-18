@extends('admin.main')

@section('content')

    <table id="sortTable" class="table table-light-sm">
        <thead style="font-size: 18px; font-style: italic">
        <tr>
            <th width="5%">ID</th>
            <th width="15%">Tên sản phẩm</th>
            <th width="15%">Mô tả</th>
            <th width="20%">Chi tiết</th>
            <th width="5%">Giá</th>
            <th width="10%">Ảnh</th>
            <th width="15%">Cây Trồng</th>
            <th width="15%">Cập nhật </th>
            <th>&nbsp</th>
        </tr>
        </thead>
        <tbody>
{{--        {!! \App\Helpers\Helper::menu($menus) !!}--}}
            @foreach($products as $key => $product)

            <tr>
                <td width="5%">{{$product->id}}</td>
                <td width="15%">{{$product->name}}</td>
                <td width="15%"><div style="height:150px; overflow:hidden">{{$product->description}}</div></td>
                <td width="17%"><div style="height:150px; overflow:hidden">{{$product->detail}}</div></td>
                <td width="8%">{{$product->price}} VND</td>
                <td width="10%"> <img width="150px" class="show-img-product rounded mx-auto d-block" src="{{$product->thumb}}" alt="Hình ảnh"></td>
                <td width="15%">{{$product->name_crop}}</td>
                <td width="15%">
                    <a style="margin-right: 5px" class="button btn-outline-warning btn-sm" href="/admin/products/edit/{{$product->id}} ">
                        <i class="fa fa-edit"></i> <i>Edit</i>
                    </a>
                    <a class="button btn-outline-danger btn-sm" href="#"
                       onclick="removeRow({{$product->id}}, '/admin/products/destroy')">
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
                    x = rows[i].getElementsByTagName("TD")[1];
                    y = rows[i + 1].getElementsByTagName("TD")[1];
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


