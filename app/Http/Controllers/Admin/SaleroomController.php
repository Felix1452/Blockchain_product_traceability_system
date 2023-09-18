<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Saleroom\SaleroomService;
use App\Models\Salesroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SaleroomController extends Controller
{
    protected $saleroomService;
    public function __construct(SaleroomService $saleroomService)
    {
        $this->saleroomService = $saleroomService;
    }

    public function index(){
        $salerooms = $this->saleroomService->get();
        return view('admin.salerooms.list',[
            "title"=>"Saleroom",
            "salerooms"=>$salerooms
        ]);
    }
    public function create(){
        return view('admin.salerooms.add',[
            "title"=>"Saleroom",
        ]);
    }


    public function store(Request $request){
        if(session()->get('perr') == 1){
            $result = $this->saleroomService->create($request);
            if($result){
                $databaseName = env('DB_DATABASE');
                $userName = env('DB_USERNAME');
                $password = env('DB_PASSWORD');
                $backupPath = storage_path('app/backup/backup_'.date("YY_m_d").date("_h_i_s").'.sql');

                $command = "mysqldump --user={$userName} --password={$password} {$databaseName} > {$backupPath}";

                exec($command, $output, $returnCode);

                if ($returnCode === 0){
//                    return response([
//                        "error"=>true,
//                        "message"=>"Thêm thành công"
//                    ]);
                    $salerooms = $this->saleroomService->get();
                    return view('admin.salerooms.list',[
                        "title"=>"Saleroom",
                        "salerooms"=>$salerooms
                    ]);
                }else{
                    return response([
                        "error"=>true,
                        "message"=>"Thêm thành công. Nhưnng Backup DB thất bại"
                    ]);
                }
            }else{
//                return response([
//                    "error"=>false,
//                    "message"=>"Thêm lỗi"
//                ]);
                return redirect()->back();
            }
        }else{
//            return response([
//                "error"=>false,
//                "message"=>"Thêm lỗi"
//            ]);
            return redirect()->back();
        }
    }




    public function show(Salesroom $salesroom){
        return view('admin.salerooms.edit',[
            'title' => 'Chỉnh sửa Saleroom: '. $salesroom->tencoso,
            'saleroom' => $salesroom
        ]);
    }

    public function update(Request $request, Salesroom $salesroom)
    {
        $result = $this->saleroomService->update($request, $salesroom);
        if($result){
            return redirect()->route('admin.salerooms.list');
        }
        else
            return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->saleroomService->destroy($request);
        if($result){
            return response()->json([
                'error' =>false,
                'message' => 'Xóa Saleroom thành công!'
            ]);
        }
        return response()->json(['error'=>true]);
    }
}
