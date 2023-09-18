<?php

namespace App\Http\Services\Seedsupplier;

use App\Models\Seedsupplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SeedsupplierService
{
    public function get(){
        return Seedsupplier::all();
    }

    public function create($request){
        $a = DB::select('select * from seedsuppliers where madoanhnghiep ="'.$request->input('madoanhnghiep').'"');
        try {
            if (sizeof($a) == 0){
                Seedsupplier::create([
                    'madoanhnghiep'=>(string)$request->input('madoanhnghiep'),
                    'tencoso'=>(string)$request->input('tencoso'),
                    'chucoso'=>(string)$request->input('chucoso'),
                    'nguoidaidienphaply'=>(string)$request->input('nguoidaidienphaply'),
                    'diachi'=>(string)$request->input('diachi'),
                    'sodienthoai'=>(string)$request->input('sodienthoai'),
                    'mota'=>(string)$request->input('mota'),
                    'thumb'=>(string)$request->input('thumb'),
                ]);
//
                Session::flash("success","Thêm nhà cung cấp thành công");
                return true;
            }else{
                Session::flash("error","Đã có nhà cung cấp này rồi");
                return false;
            }
        }catch (\Exception $err){
            Session::flash("error",'Lỗi');
            return false;
        }
    }

    public function update($request, $seedsupplier){
        try {
            //-----------------------
            $seedsupplier->madoanhnghiep = (string) $request->input('madoanhnghiep');
            $seedsupplier->tencoso = (string) $request->input('tencoso');
            $seedsupplier->chucoso = (string) $request->input('chucoso');
            $seedsupplier->nguoidaidienphaply = (string) $request->input('nguoidaidienphaply');
            $seedsupplier->diachi = (string) $request->input('diachi');
            $seedsupplier->sodienthoai = (string) $request->input('sodienthoai');
            $seedsupplier->mota = (string) $request->input('mota');
            $seedsupplier->thumb = (string) $request->input('thumb');
            $seedsupplier->save();
            Session::flash('success', 'Cập nhật thành công !');
        }
        catch (\Exception $err){
            Session::flash('error','Lỗi');
            return false;
        }
        return true;
    }

    public function destroy($request){
        $id = (int)$request->input('id');
        $seedsupplier = Seedsupplier::where('id', $id)->first();
        if ($seedsupplier) {
            $seedsupplier->delete();
            return true;
        }
        return false;
    }
}
