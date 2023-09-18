<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Crop\CropService;
use App\Http\Services\SeedsandSeedling\SeedsandSeedlingsService;
use App\Models\Crop;
use App\Models\Seedsandseedling;
use Illuminate\Http\Request;

class CropController extends Controller
{
    protected $cropService;
    public function __construct(CropService $cropService)
    {
        $this->cropService = $cropService;
    }

    public function index(){
        $crops = $this->cropService->get();
        return view('admin.crops.list',[
            "title"=>"Cây Trồng",
            "crops"=>$crops,
        ]);
    }

    public function create(){
        $farmers = $this->cropService->getFarmer();
        $seedsandseedlings = $this->cropService->getSeedsandSeedling();
        return view('admin.crops.add',[
            "title"=>"Cây Trồng",
            "farmers"=>$farmers,
            "seedsandseedlings"=>$seedsandseedlings
        ]);
    }

    public function store(Request $request){
        if(session()->get('perr') == 1){
            $result = $this->cropService->create($request);
            if($result){
                return redirect()->route('admin.crops.list');
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
    }

    public function show(Crop $crop){
        $farmers = $this->cropService->getFarmer();
        $seedsandseedlings = $this->cropService->getSeedsandSeedling();
        $cropId = $this->cropService->getId($crop->id);
//        dd($cropId);
        return view('admin.crops.edit',[
            'title' => 'Chỉnh sửa Cây Trồng: '. $crop->name,
            'crop' => $cropId[0],
            "seedsandseedlings"=>$seedsandseedlings,
            "farmers"=>$farmers
        ]);
    }

    public function update(Request $request, Crop $crop)
    {
//        dd($request->input());
        $result = $this->cropService->update($request, $crop);
        if($result){
            return redirect()->route('admin.crops.list');
        }
        else
            return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->cropService->destroy($request);
        if($result){
            return response()->json([
                'error' =>false,
                'message' => 'Xóa Cây Trồng thành công!'
            ]);
        }
        return response()->json(['error'=>true]);
    }
}
