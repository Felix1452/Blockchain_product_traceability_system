<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Farmer\FarmerService;
use App\Models\Farmer;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    protected $farmerService;
    public function __construct(FarmerService $farmerService)
    {
        $this->farmerService = $farmerService;
    }

    public function index(){
        $farmers = $this->farmerService->get();
        return view('admin.farmers.list',[
            "title"=>"Nhà Vườn",
            "farmers"=>$farmers
        ]);
    }
    public function create(){
        return view('admin.farmers.add',[
            "title"=>"Nhà Vườn",
        ]);
    }

    public function store(Request $request){
        if(session()->get('perr') == 1){
            $result = $this->farmerService->create($request);
            if($result){
                return redirect()->route('admin.farmers.list');
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
    }

    public function show(Farmer $farmer){
        return view('admin.farmers.edit',[
            'title' => 'Chỉnh sửa nhà vườn: '. $farmer->tencoso,
            'farmers' => $farmer
        ]);
    }

    public function update(Request $request, Farmer $farmer)
    {
        $result = $this->farmerService->update($request, $farmer);
        if($result){
            return redirect()->route('admin.farmers.list');
        }
        else
            return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->farmerService->destroy($request);
        if($result){
            return response()->json([
                'error' =>false,
                'message' => 'Xóa nhà vườn thành công!'
            ]);
        }
        return response()->json(['error'=>true]);
    }
}
