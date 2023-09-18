<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Seedsupplier\SeedsupplierService;
use App\Models\Seedsupplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SeedsupplierController extends Controller
{
    protected $seedsupplierService;
    public function __construct(SeedsupplierService $seedsupplierService)
    {
        $this->seedsupplierService = $seedsupplierService;
    }

    public function index(){
        $suppliers = $this->seedsupplierService->get();
        return view('admin.seedsuppliers.list',[
            "title"=>"Nhà Cung Cấp Giống",
            "seedsuppliers"=>$suppliers
        ]);
    }
    public function create(){
        return view('admin.seedsuppliers.add',[
            "title"=>"Nhà Cung Cấp Giống",
        ]);
    }

    public function store(Request $request){
        if(session()->get('perr') == 1){
            $result = $this->seedsupplierService->create($request);
            if($result){
                return redirect()->route('admin.seedsuppliers.list');
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
    }

    public function show(Seedsupplier $seedsupplier){
        return view('admin.seedsuppliers.edit',[
            'title' => 'Chỉnh sửa nhà cung cấp: '. $seedsupplier->tencoso,
            'seedsuppliers' => $seedsupplier
        ]);
    }

    public function update(Request $request, Seedsupplier $seedsupplier)
    {
        $result = $this->seedsupplierService->update($request, $seedsupplier);
        if($result){
            return redirect()->route('admin.seedsuppliers.list');
        }
        else
            return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->seedsupplierService->destroy($request);
        if($result){
            return response()->json([
                'error' =>false,
                'message' => 'Xóa nhà cung cấp thành công!'
            ]);
        }
        return response()->json(['error'=>true]);
    }
}
