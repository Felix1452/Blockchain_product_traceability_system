<?php

namespace App\Http\Services\SeedsandSeedling;

use App\Models\Salesroom;
use App\Models\Seedsandseedling;
use App\Models\Seedsupplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SeedsandSeedlingsService
{
    public function get(){
        $result = DB::select('select seedsandseedlings.id, seedsandseedlings.name, seedsandseedlings.description, seedsandseedlings.detail, seedsandseedlings.thumb, seedsuppliers.tencoso
                                    from seedsandseedlings, seedsuppliers
                                    where seedsuppliers.id = seedsandseedlings.id_seedsupplier');
        return $result;
    }

    public function getSupplier(){
        $result = Seedsupplier::all();
        return $result;
    }

    public function getId($id){
        $result = DB::select('select seedsandseedlings.id, seedsandseedlings.name, seedsandseedlings.description, seedsandseedlings.detail, seedsandseedlings.id_seedsupplier, seedsuppliers.tencoso, seedsandseedlings.thumb
                                    from seedsandseedlings, seedsuppliers
                                    where seedsuppliers.id = seedsandseedlings.id_seedsupplier and seedsandseedlings.id = '.$id);
        return $result;
    }

    public function create($request){
        try {
            Seedsandseedling::create([
                'name'=>(string)$request->input('name'),
                'description'=>(string)$request->input('description'),
                'detail'=>(string)$request->input('detail'),
                'id_seedsupplier'=>(string)$request->input('id_seedsupplier'),
                'thumb'=>(string)$request->input('thumb'),
            ]);
            Session::flash("success","Thêm thành công");
            return true;
        }catch (\Exception $err){
            Session::flash("error",'Lỗi');
            return false;
        }
    }

    public function update($request, $seedsandseedling){
        try {
            //-----------------------
            $seedsandseedling->name = (string)$request->input('name');
            $seedsandseedling->description = (string)$request->input('description');
            $seedsandseedling->detail = (string)$request->input('detail');
            $seedsandseedling->id_seedsupplier = (string)$request->input('id_seedsupplier');
            $seedsandseedling->thumb = (string)$request->input('thumb');
            $seedsandseedling->save();
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
        $saleroom = Seedsandseedling::where('id', $id)->first();
        if ($saleroom) {
            $saleroom->delete();
            return true;
        }
        return false;
    }
}
