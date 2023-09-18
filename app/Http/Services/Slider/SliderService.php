<?php

namespace App\Http\Services\Slider;

use App\Models\Slider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SliderService
{
    public function insert($request){
        try {
            Slider::create([
                'name'=>$request->input("name"),
                'url'=>$request->input("url"),
                'thumb'=>$request->input("thumb"),
                'sort_by'=>$request->input("sort_by"),
                'active'=>$request->input("active")
            ]);
            Session::flash('success','Tạo slider thành công !');
        }catch (\Exception $err){
            Session::flash('error',$err->getMessage());
            return false;
        }
        return true;
    }

    public function get(){
        return Slider::orderByDesc('id')->paginate(10);
    }

    public function update($request, $slider){
        try {
//            $slider->fill($request->input());
            $slider->name = (string) $request->input('name');
            $slider->url = (string) $request->input('url');
            $slider->sort_by = (string) $request->input('sort_by');
            $slider->thumb = (string) $request->input('thumb');
            $slider->active = (string) $request->input('active');
            $slider->save();
            Session::flash('success','Cập nhật slider thành công !');
        }catch (\Exception $err){
            Session::flash('error',$err->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($request){
        $id = (int)$request->input('id');
        $slider = Slider::where('id', $id)->first();
        if ($slider) {
            $path = str_replace('storage','public', $slider->thumb);
            Storage::delete($path);
            $slider->delete();
            return true;
        }
        return false;
    }

    public function show(){
        return Slider::where('active',1)->orderBy('sort_by')->get();
    }
}
