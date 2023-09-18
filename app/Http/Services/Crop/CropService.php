<?php

namespace App\Http\Services\Crop;

use App\Models\Crop;
use App\Models\Farmer;
use App\Models\Seedsandseedling;
use App\Models\Seedsupplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CropService
{
    public function get(){
        $result = DB::select('select crops.id, crops.name, crops.description, crops.detail, crops.thumb, seedsandseedlings.name as name_seedsandseedling, farmers.tencoso as name_farmer
                                    from crops, seedsandseedlings, farmers
                                    where crops.id_seedandseedling = seedsandseedlings.id and crops.id_farmer = farmers.id');
        return $result;
    }

    public function getFarmer(){
        return Farmer::all();
    }

    public function getSeedsandSeedling(){
        return Seedsandseedling::all();
    }

    public function getId($id){
        $result = DB::select('select *
                                    from  crops
                                    where crops.id = '.$id);
        return $result;
    }

    public function create($request){
        try {
            Crop::create([
                'name'=>(string)$request->input('name'),
                'description'=>(string)$request->input('description'),
                'detail'=>(string)$request->input('detail'),
                'id_seedandseedling'=>(string)$request->input('id_seedandseedling'),
                'id_farmer'=>(string)$request->input('id_farmer'),
                'thumb'=>(string)$request->input('thumb'),
            ]);
            Session::flash("success","Thêm thành công");
            return true;
        }catch (\Exception $err){
            Session::flash("error",'Lỗi');
            return false;
        }
    }

    public function update($request, $crop){
        try {
            //-----------------------
            $crop->name = (string)$request->input('name');
            $crop->description = (string)$request->input('description');
            $crop->detail = (string)$request->input('detail');
            $crop->id_seedandseedling = (string)$request->input('id_seedandseedling');
            $crop->id_farmer = (string)$request->input('id_farmer');
            $crop->thumb = (string)$request->input('thumb');
            $crop->save();
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
        $crop = Crop::where('id', $id)->first();
        if ($crop) {
            $crop->delete();
            return true;
        }
        return false;
    }
}
