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

@endsection

@section('footer')

@endsection
