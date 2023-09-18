<?php

namespace App\Http\Services\Farmer;

use App\Models\Farmer;
use App\Models\Seedsupplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FarmerService
{
    public function get(){
        return Farmer::all();
    }

    public function create($request){
        $a = DB::select('select * from farmers where mavungtrong ="'.$request->input('mavungtrong').'"');
        try {
            if (sizeof($a) == 0){
                Farmer::create([
                    'mavungtrong'=>(string)$request->input('mavungtrong'),
                    'tencoso'=>(string)$request->input('tencoso'),
                    'tenchunhatrong'=>(string)$request->input('tenchunhatrong'),
                    'diachi'=>(string)$request->input('diachi'),
                    'sodienthoai'=>(string)$request->input('sodienthoai'),
                    'mota'=>(string)$request->input('mota'),
                    'thumb'=>(string)$request->input('thumb'),
                ]);
//
                Session::flash("success","Thêm nhà vuờn thành công");
                return true;
            }else{
                Session::flash("error","Đã có nhà vườn này rồi");
                return false;
            }
        }catch (\Exception $err){
            Session::flash("error",'Lỗi');
            return false;
        }
    }

    public function update($request, $farmer){
        try {
            //-----------------------
            $farmer->mavungtrong=(string)$request->input('mavungtrong');
            $farmer->tencoso=(string)$request->input('tencoso');
            $farmer->tenchunhatrong=(string)$request->input('tenchunhatrong');
            $farmer->diachi=(string)$request->input('diachi');
            $farmer->sodienthoai=(string)$request->input('sodienthoai');
            $farmer->mota=(string)$request->input('mota');
            $farmer->thumb=(string)$request->input('thumb');
            $farmer->save();
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
        $farmer = Farmer::where('id', $id)->first();
        if ($farmer) {
            $farmer->delete();
            return true;
        }
        return false;
    }
}
