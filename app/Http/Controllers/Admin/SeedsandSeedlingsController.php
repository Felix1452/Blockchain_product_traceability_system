<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\SeedsandSeedling\SeedsandSeedlingsService;
use App\Http\Services\Seedsupplier\SeedsupplierService;
use App\Models\Seedsandseedling;
use App\Models\Seedsupplier;
use Illuminate\Http\Request;

class SeedsandSeedlingsController extends Controller
{
    protected $seedsandseedlingService;
    public function __construct(SeedsandSeedlingsService $seedsandseedlingService)
    {
        $this->seedsandseedlingService = $seedsandseedlingService;
    }

    public function index(){
        $seedsandseedlings = $this->seedsandseedlingService->get();
        return view('admin.seedsandseedlings.list',[
            "title"=>"Hạt Giống Và Cây Giống",
            "seedsandseedlings"=>$seedsandseedlings,
        ]);
    }
    public function create(){
        $suppliers = $this->seedsandseedlingService->getSupplier();
        return view('admin.seedsandseedlings.add',[
            "title"=>"Hạt Giống Và Cây Giống",
            "seedsuppliers"=>$suppliers
        ]);
    }

    public function store(Request $request){
//        dd($request->input());
        if(session()->get('perr') == 1){
            $result = $this->seedsandseedlingService->create($request);
            if($result){
                return redirect()->route('admin.seedsandseedlings.list');
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
    }

    public function show(Seedsandseedling $seedsandseedling){
        $seedsuppliers = $this->seedsandseedlingService->getSupplier();
        $seedsandseedlingId = $this->seedsandseedlingService->getId($seedsandseedling->id);
        return view('admin.seedsandseedlings.edit',[
            'title' => 'Chỉnh sửa Hạt Giống Và Cây Giống: '. $seedsandseedling->tencoso,
            'seedsandseedling' => $seedsandseedlingId[0],
            "seedsuppliers"=>$seedsuppliers
        ]);
    }

    public function update(Request $request, Seedsandseedling $seedsandseedling)
    {
        $result = $this->seedsandseedlingService->update($request, $seedsandseedling);
        if($result){
            return redirect()->route('admin.seedsandseedlings.list');
        }
        else
            return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->seedsandseedlingService->destroy($request);
        if($result){
            return response()->json([
                'error' =>false,
                'message' => 'Xóa Hạt Giống Và Cây Giống thành công!'
            ]);
        }
        return response()->json(['error'=>true]);
    }
}
