@extends('admin.main')

@section('head')
@endsection
@include('admin.alert')

@section('content')

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="card-body">

            <div class="form-group">
                <label for="">Chuỗi Siêu Thị</label>
                <?php
                    $arrs = explode(",",$billreceived->list_saleroom);
                    $i = 0;
                ?>
                    @foreach($salerooms as $saleroom)
                        @if($saleroom->id == (int)$arrs[$i])
                        <?php $i = $i + 1;
                        ?>
                            <div class="form-check">
                                <input class="form-check-input" name="saleroom[]" checked type="checkbox" value="{{ $saleroom->id }}" id="{{ $saleroom->id }}">
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ $saleroom->tencoso }}
                                </label>
                            </div>

                        @else
                            <div class="form-check">
                                <input class="form-check-input" name="saleroom[]" type="checkbox" value="{{ $saleroom->id }}" id="{{ $saleroom->id }}">
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ $saleroom->tencoso }}
                                </label>
                            </div>

                        @endif
                    @endforeach
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật Hóa Đơn Nhập hàng</button>
        </div>
        @csrf
    </form>
@endsection

@section('footer')
@endsection
