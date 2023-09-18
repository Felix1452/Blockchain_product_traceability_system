@extends('admin.main')

@section('head')
    <script src='/ckeditor/ckeditor.js' }}></script>
@endsection

@section('content')
    <form action="" method="POST">
        <div class="card-body">
            <div class="form-group">
                <label for="menu">Nhà Cung Cấp Giống</label>
                <select class="form-control" name="seedsupplier">
                    @foreach($seedSuppliers as $seedsupplier)
                        <option value="{{$seedsupplier->id}}">{{$seedsupplier->tencoso}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="menu">Nhà Cung Cấp Giống</label>
                <select class="form-control" name="farmer">
                    @foreach($farmers as $farmer)
                        <option value="{{$farmer->id}}">{{$farmer->tenchunhatrong. " - " . $farmer->mavungtrong}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="menu">Nhà Cung Cấp Giống</label>
                <select class="form-control" name="saleroom">
                    @foreach($salerooms as $saleroom)
                        <option value="{{$saleroom->id}}">{{$saleroom->tencoso}}</option>
                    @endforeach
                </select>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card-footer">
            <button type="submit" id="submit" class="btn btn-primary">Save</button>
        </div>
        @csrf
    </form>

    <div class="card-footer">
        <button onclick="btAnimation()" id="submit" class="btn btn-primary">Save</button>
    </div>


{{--    <table class="table table-light-sm">--}}
{{--        <thead style="font-size: 18px; font-style: italic">--}}
{{--        <tr>--}}
{{--            <th width="5%">ID</th>--}}
{{--            <th width="20%">Tên Slider</th>--}}
{{--            <th width="200px">Đường dẫn</th>--}}
{{--            <th width="20%">Ảnh</th>--}}
{{--            <th width="10%">Kích hoạt</th>--}}
{{--            <th width="15%">Cập nhật </th>--}}
{{--            <th width="20%">&nbsp</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        --}}{{--        {!! \App\Helpers\Helper::menu($menus) !!}--}}
{{--        @foreach($sliders as $key => $slider)--}}
{{--            <tr>--}}
{{--                <td>{{$slider->id}}</td>--}}
{{--                <td><textarea readonly style="box-sizing: border-box;height: 150px; border: 0px solid white; border-radius: 4px;resize: none;">{{$slider->name}}</textarea></td>--}}
{{--                <td><textarea readonly style="box-sizing: border-box;height: 150px; border: 0px solid white; border-radius: 4px;resize: none;">{{$slider->url}}</textarea></td>--}}
{{--                <td><a  href="{{$slider->thumb}}" target="_blank"><img style="border-radius: 5%; max-width: 15vmax; max-height: 15vmax" src="{{$slider->thumb}}"></a></td>--}}
{{--                <td>{!! \App\Helpers\Helper::active($slider->active) !!}</td>--}}
{{--                <td>{{$slider->updated_at}}</td>--}}
{{--                <td>--}}
{{--                    <a style="margin-right: 5px" class="button btn-outline-warning btn-sm" href="/admin/sliders/edit/{{$slider->id}} ">--}}
{{--                        <i class="fa fa-edit"></i> <i>Edit</i>--}}
{{--                    </a>--}}
{{--                    <a class="button btn-outline-danger btn-sm" href="#"--}}
{{--                       onclick="removeRow({{$slider->id}}, '/admin/sliders/destroy')">--}}
{{--                        <i class="fa fa-trash"></i> <i>Delete</i>--}}
{{--                    </a>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--    {!! $sliders->links('my-paginate') !!}--}}



@endsection

@section('footer')

@endsection
