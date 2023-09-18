<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Slider\SliderService;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $slider;

    public function __construct(SliderService $slider)
    {
        $this->slider = $slider;
    }

    public function create()
    {
        return view('admin.sliders.add', [
            'title' => 'Thêm Slider Mới'
        ]);
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
            'url' => 'required'
        ]);

        $result = $this->slider->insert($request);
        if($result){
            return redirect('/admin/sliders/list');
        }
        else
            return redirect()->back();
    }

    public function index(){
        return view('admin.sliders.list',[
            'title' => 'Danh sách sliders ',
            'sliders' => $this->slider->get()
        ]);
    }

    public function show(Slider $slider){
        return view('admin.sliders.edit',[
            'title' => 'Chỉnh sửa slider: '. $slider->name,
            'sliders' => $slider
        ]);
    }

    public function update(Request $request, Slider $slider){
        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
            'url' => 'required'
        ]);
        $result= $this->slider->update($request, $slider);
        if($result){
            return redirect('/admin/sliders/list');
        }
        else
            return redirect()->back();
    }

    public function destroy(Request $request){
        $result = $this->slider->destroy($request);
        if($result){
            return response()->json([
                'error' =>false,
                'message' => 'Xóa slider thành công!'
            ]);
        }
        return response()->json(['error'=>true]);
    }
}
