<?php

namespace App\Http\Services\Saleroom;

use App\Helpers\GlobalVariable;
use App\Http\BlockChain\Blockchain;
use App\Models\Billreceived;
use App\Models\Farmer;
use App\Models\Salesroom;
use App\Models\Salesroomchain;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Web3\Contract;
use Web3\Web3;

class SaleroomService
{
    public function get(){
        return Salesroom::all();
    }

    public function create($request){
        $a = DB::select('select * from salesrooms where madoanhnghiep ="'.$request->input('madoanhnghiep').'"');

        try {
            if (sizeof($a) == 0){
                Salesroom::create([
                    'madoanhnghiep'=>(string)$request->input('madoanhnghiep'),
                    'tencoso'=>(string)$request->input('tencoso'),
                    'tennguoidaidien'=>(string)$request->input('tennguoidaidien'),
                    'tenchucoso'=>(string)$request->input('tenchucoso'),
                    'sodienthoai'=>(string)$request->input('sodienthoai'),
                    'diachi'=>(string)$request->input('diachi'),
                    'mota'=>(string)$request->input('mota'),
                    'thumb_saleroom'=>(string)$request->input('thumb_saleroom'),
                ]);

                $salerooms = DB::select('SELECT * FROM `salesrooms` ORDER BY id DESC  LIMIT 1 ');
                $madoanhnghiep = $salerooms[0]->madoanhnghiep;
                $tencoso = $salerooms[0]->tencoso;
                $diachi = $salerooms[0]->diachi;
                $thumb_saleroom = $salerooms[0]->thumb_saleroom;
                $created_at = $salerooms[0]->created_at;

                $arrayValue = [ "madoanhnghiep"=>$madoanhnghiep, "tencoso"=>$tencoso, "diachi"=>$diachi,
                                "thumb_saleroom"=>$thumb_saleroom, "created_at"=>$created_at];





                ##--------------------------Create BlockChain-------------------------------
                $web3 = new Web3('http://127.0.0.1:7545');
//            dd($web3->provider);
                $contractABI = json_decode(file_get_contents(resource_path('contracts/abi.json')), true);
                $contractAddress = '0x26b2Cc501dD330d0e162c20D52f0D1A697A50AE3';
                $contract = new Contract($web3->provider, $contractABI);
                $contract->at($contractAddress);
//            dd($contract);



                $web3->eth->accounts(function ($err, $accounts) use ($contract, $arrayValue, $contractAddress) {
                    if ($err !== null) {
                        // Handle error
                        echo 'Error: ' . $err->getMessage();
                        return;
                    }

                    $senderAddress = '0x50b9f1fa42f0e81Fd3d360ADBD57ec4D2BF936cB';
                    $senderPrivateKey = '0x6899a051e112b5fc676724268560f17c561bf6968734803d759acccfe35f37e8';

                    $fromAddress = $accounts[0];  // Use the first account for the transaction
                    $toAddress = $accounts[1];
//                    dd($toAddress);

                    $contract->call('countSaleroom', function ($err, $result) use ($contract, $arrayValue, $fromAddress, $toAddress, $contractAddress ) {
                        if ($err !== null) {
                            // Handle error
                            echo 'Error: ' . $err->getMessage();
                        }else{
//                    echo 'Số khối: ' . $result;
                            $countBlock = json_decode(json_encode($result[0]->value));
                            //-----------------------------------------Add Block-------------------------------------
                            if ($countBlock != 0){
//                            dd(1);
                                $a = DB::select('select * from salesroomchains');
                                $saleroomsLast = json_decode($a[0]->blockchain_salesroom);
//                                dd($saleroomsLast);
                                $saleroomsChain = new Blockchain(2);
                                $saleroomsChain->chain = $saleroomsLast->chain;
//                                dd(json_encode($saleroomsChain->chain));
                                $saleroomsChain->difficulty = $saleroomsLast->difficulty;

                                $value = $saleroomsChain->getLastBlock()->hash;

                                $saleroomsChain->addBlock($arrayValue);
                                $valid = $saleroomsChain->isValid();

                                if ($valid == false){
                                    dd("Chuỗi khối Salesroom bị sửa đổi");
                                }


                                $valueAdd = $saleroomsChain->getLastBlock()->hash;

                                $minevar = (string)$saleroomsChain->getLastBlock()->mineVar."phuc";
//                                dd($value);

                                $valueAdd = $valueAdd.$minevar;

                                $contract->call('arrSaleroom', (int)($countBlock-1) , function ($err, $result)  {
                                    if ($err !== null) {
                                        // Handle error
                                        echo 'Error: ' . $err->getMessage();
                                        GlobalVariable::$errorCheckSaleroom = 1;
                                    }

                                    GlobalVariable::$resultSaleroom = $result;
                                });

                                if (GlobalVariable::$errorCheckSaleroom == 0){
                                    $compare = $value.GlobalVariable::$resultSaleroom["_minevar"];
                                    if (md5($compare) == GlobalVariable::$resultSaleroom["_hash"]){
//                                        dd("giống");
                                        Salesroomchain::where('id',$a[0]->id)->update(array(
                                            'blockchain_salesroom'=>json_encode($saleroomsChain)
                                        ));

                                        $contract->send('DangKySaleroom', md5($valueAdd), $minevar, [
                                            'from' => $fromAddress,
                                            'to' => $contractAddress,
                                            'gas' => 2000000,
                                            'gasPrice' => 1000000000,
                                        ], function ($err, $result) {
                                            if ($err !== null) {
                                                // Handle error
                                                echo 'Error: ' . $err->getMessage();
                                            }
                                        });

                                    }else{
                                        dd("Không giống");
                                    }
                                }
                                else{
                                    dd("Lấy dữ liệu lỗi");
                                }
                            }
                            else{
                                $saleroomChain = new Blockchain(2);
                                $saleroomChain->addBlock($arrayValue);
                                $valid = $saleroomChain->isValid();


//                                dd($saleroomChain->getLastBlock());
                                if ($valid == false){
                                    dd("Chuỗi khối Salesroom khởi tạo sai");
                                }

                                $value = $saleroomChain->getLastBlock()->hash;
                                $minevar = $saleroomChain->getLastBlock()->mineVar."phuc";
                                $value = $value.$minevar;
                                $contract->call('DangKySaleroom', "aaa", "aaa", function ($err, $result) {
                                    if ($err !== null) {
                                        // Handle error
                                        echo 'Error: ' . $err->getMessage();
                                    }
                                });

                                $contract->send('DangKySaleroom', "aaa", "aaa", [
                                    'from' => $fromAddress,
                                    'to' => $contractAddress,
                                    'gas' => 2000000,
                                    'gasPrice' => 1000000000,
                                ], function ($err, $result) {
                                    if ($err !== null) {
                                        // Handle error
                                        echo 'Error: ' . $err->getMessage();
                                    }
                                });

                                $contract->send('DangKySaleroom', md5($value), $minevar, [
                                    'from' => $fromAddress,
                                    'to' => $contractAddress,
                                    'gas' => 2000000,
                                    'gasPrice' => 1000000000,
                                ], function ($err, $result) {
                                    if ($err !== null) {
                                        // Handle error
                                        echo 'Error: ' . $err->getMessage();
                                    }
                                });

                                //----------------------update MySQL SalesroomChain------------------
                                Salesroomchain::create([
                                    'blockchain_salesroom'=>json_encode($saleroomChain)
                                ]);
                            }
                        }
                    });
                });
                return true;
            }else{
                Session::flash("error","Đã có Saleroom này rồi");
                return false;
            }
        }catch (\Exception $err){
            Session::flash("error",'Lỗi');
            return false;
        }
    }

    public function update($request, $saleroom){
        try {
            //-----------------------
            $saleroom->madoanhnghiep=(string)$request->input('madoanhnghiep');
            $saleroom->tencoso=(string)$request->input('tencoso');
            $saleroom->tennguoidaidien=(string)$request->input('tennguoidaidien');
            $saleroom->tenchucoso=(string)$request->input('tenchucoso');
            $saleroom->sodienthoai=(string)$request->input('sodienthoai');
            $saleroom->diachi=(string)$request->input('diachi');
            $saleroom->mota=(string)$request->input('mota');
            $saleroom->thumb_saleroom=(string)$request->input('thumb_saleroom');
            $saleroom->save();
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
        $saleroom = Salesroom::where('id', $id)->first();
        if ($saleroom) {
            $saleroom->delete();
            return true;
        }
        return false;
    }
}
