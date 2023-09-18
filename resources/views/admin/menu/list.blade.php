@extends('admin.main')

@section('content')

    <table class="table table-light-sm">
        <thead style="font-size: 18px; font-style: italic">
        <tr>
            <th>ID</th>
            <th style="width: 30%">Tên danh mục </th>
            <th>Kích hoạt </th>
            <th>Danh mục cha </th>
            <th>Ảnh</th>
            <th>Cập nhật </th>
            <th>&nbsp</th>
        </tr>
        </thead>
        <tbody>
        {!! \App\Helpers\Helper::menu($menus) !!}
        </tbody>
    </table>
    {!! $menus->links('my-paginate') !!}
@endsection
