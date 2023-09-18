<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Billreceived\BillreceivedService;
use App\Models\Billreceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BillreceivedController extends Controller
{
    protected $billreceivedService;
    public function __construct(BillreceivedService $billreceivedService)
    {
        $this->billreceivedService = $billreceivedService;
    }

    public function index(){
        $billreceiveds = $this->billreceivedService->get();
        $salerooms = $this->billreceivedService->getSaleroom();
        return view('admin.billreceiveds.list',[
            "title"=>"Hoá Đơn Nhập Hàng",
            "billreceiveds"=>$billreceiveds,
            "salerooms"=>$salerooms
        ]);
    }
    public function create(){
        $products = $this->billreceivedService->getProduct();
        $salerooms = $this->billreceivedService->getSaleroom();
        $firstProduct = $this->billreceivedService->getFirstProduct();
//        dd($firstProduct);
        return view('admin.billreceiveds.add',[
            "title"=>"Hoá Đơn Nhập Hàng",
            "products"=>$products,
            "salerooms"=>$salerooms,
            "firstProduct"=>$firstProduct
        ]);
    }

    public function store(Request $request){
//        dd($request->input("saleroom"));
        if(session()->get('perr') == 1){
            $result = $this->billreceivedService->create($request);
            if($result){
                $databaseName = env('DB_DATABASE');
                $userName = env('DB_USERNAME');
                $password = env('DB_PASSWORD');
                $backupPath = storage_path('app/backup/backup_'.date("YY_m_d").date("_h_i_s").'.sql');

                $command = "mysqldump --user={$userName} --password={$password} {$databaseName} > {$backupPath}";

                exec($command, $output, $returnCode);


                if ($returnCode == 0){
                    Session::flash("success","Thêm thành công");
                    return redirect()->route('admin.billreceiveds.list');
                }else{
                    Session::flash("success","Backup Database thất bại");
                    return redirect()->route('admin.billreceiveds.list');
                }

            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
    }

    public function show(Billreceived $billreceived){
        $products = $this->billreceivedService->getProduct();
        $salerooms = $this->billreceivedService->getSaleroom();
        $billreceivedId = $this->billreceivedService->getId($billreceived->id);
        return view('admin.billreceiveds.edit',[
            'title' => 'Chỉnh sửa Hoá Đơn Nhập Hàng: '. $billreceived->name,
            'billreceived' => $billreceivedId[0],
            "products"=>$products,
            "salerooms"=>$salerooms
        ]);
    }

    public function update(Request $request, Billreceived $billreceived)
    {
        $result = $this->billreceivedService->update($request, $billreceived);
        if($result){
            return redirect()->route('admin.billreceiveds.list');
        }
        else
            return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->billreceivedService->destroy($request);
        if($result){
            return response()->json([
                'error' =>false,
                'message' => 'Xóa Hoá Đơn Nhập Hàng thành công!'
            ]);
        }
        return response()->json(['error'=>true]);
    }

    public function createDatabaseBackup()
    {
        $databaseName = env('DB_DATABASE');
        $userName = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $backupPath = storage_path('app/backup/backup_'.date("YY_m_d").'.sql');
//        dd($backupPath);

        $command = "mysqldump --user={$userName} --password={$password} {$databaseName} > {$backupPath}";

        exec($command, $output, $returnCode);

        if ($returnCode === 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getProductValue(Request $request){

        $getProductValue = $this->billreceivedService->getProductValue($request->id_product);


        $mavungtrong = $getProductValue[0]->mavungtrong;
        $madoanhnghiep = $getProductValue[0]->madoanhnghiep;
        $tenchunhatrong = $getProductValue[0]->tenchunhatrong;
        $tencoso = $getProductValue[0]->tencoso;
        $thumb = $getProductValue[0]->thumb;


        return response()->json([
            'error' =>true,
            'mavungtrong' => $mavungtrong,
            'madoanhnghiep' => $madoanhnghiep,
            'tenchunhatrong' => $tenchunhatrong,
            'tencoso' => $tencoso,
            'thumb'=>$thumb
        ]);
    }

}
