@extends('admin.main')

@section('content')

    <table class="table table-light-sm">
        <thead style="font-size: 18px; font-style: italic">
        <tr>
            <th width="5%">SOHD</th>
            <th width="12%">Tên Sản Phẩm</th>
            <th width="8%">Số Lượng</th>
            <th width="5%">Giá</th>
            <th width="8%">Thành Tiền</th>
            <th width="12%">Ngày Xuất Hàng</th>
            <th width="12%">Ngày Hết Hạn</th>
            <th width="15%">Chuỗi Siêu Thị</th>
            <th width="10%">QR code</th>
            <th width="10%">Cập nhật</th>
        </tr>
        </thead>
        <tbody>
                <?php
                    $i = 0 ;
                $j = 0;
                    $stringSaleroom = "";
                ?>
                @foreach($billreceiveds as $key => $billreceived)
                    <tr>
                        <td>{{$billreceived->id}}</td>
                        <td>{{$billreceived->name}}</td>
                        <td>{{$billreceived->quantity}}</td>
                        <td>{{$billreceived->price}}</td>
                        <td>{{$billreceived->total_price}}</td>
                        <td>{{$billreceived->created_at}}</td>
                        <td>{{$billreceived->shelf_life}}</td>
                        <td>
                            <?php

                                $arrs = explode(",",$billreceiveds[$j]->list_saleroom);
                            ?>
                            @for($i=0;$i<sizeof($arrs);$i++)
                                @foreach($salerooms as $key => $saleroom)
                                    @if($saleroom->id == (int)$arrs[$i])
                                       • {{ $saleroom->tencoso }} <br>
                                    @endif
                                @endforeach
                            @endfor


                        </td>
                        <td><img width="120px" src="{{$billreceived->qrcode}}" alt="QR code"></td>
                        <td>
                            <a style="margin-right: 5px" class="button btn-outline-warning btn-sm" href="/admin/billreceiveds/edit/{{$billreceived->id}} ">
                                <i class="fa fa-edit"></i> <i>Edit</i>
                            </a>
                        </td>
                    </tr>
                    <?php $j++ ?>
                @endforeach
        </tbody>
    </table>
@endsection


