<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\GlobalVariable;
use App\Http\BlockChain\Blockchain;
use App\Http\Controllers\Controller;
use App\Models\Salesroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Web3\Contract;
use Web3\Web3;

class CheckBlockController extends Controller
{
    public function check(){
        $a = DB::select('select * from blockchaindbs');
        $blockchain = $a[0]->blockchain;
        $blockchain = json_decode($blockchain);
        $hoangChainLast = $blockchain;
        $hoangChain = new Blockchain(2);
        $hoangChain->chain = $hoangChainLast->chain;
        $hoangChain->difficulty = $hoangChainLast->difficulty;
        $valid = $hoangChain->isValid();
        if ($valid == true){
            $web3 = new Web3('http://127.0.0.1:7545');
            $contractABI = json_decode(file_get_contents(resource_path('contracts/abi.json')), true);
            $contractAddress = '0x9e44F6F123bf1144A27054Cb297C2d09a0EBf7eA';
            $contract = new Contract($web3->provider, $contractABI);
            $contract->at($contractAddress);
//                dd("haha");


            $contract->call('countBill', function ($err, $result) use ($contract, $hoangChain, $contractAddress ) {
                if ($err !== null) {
                    // Handle error
                    echo 'Error: ' . $err->getMessage();
                }
                else{
//                    echo 'Số khối: ' . $result;
                    $countBlock = json_decode(json_encode($result[0]->value));
                    GlobalVariable::$web3Result =  $countBlock;
//                            dd($countBlock);
                    //-----------------------------------------Add Block-------------------------------------
                    if ($countBlock > 0 && $number < $countBlock){


                        $contract->call('arrBlockChain', (int)$number , function ($err, $result) use ($blockchaindb, $contractAddress) {
                            if ($err !== null) {
                                // Handle error
                                echo 'Error: ' . $err->getMessage();
                            }

                            GlobalVariable::$web3Result = $result;
                        });
                    }else{
                        GlobalVariable::$error_Web3 = 1;
                    }
                }
            });

            if (GlobalVariable::$error_Web3 != 0){
                return  view('warning',[
                    "title"=>"QR Code Đã Bị Can Thiệp!",
                    "content"=>"Chúng tôi phát hiện QR code của bạn đã bị can thiệp."
                ]);
            }

            $block = json_decode($blockchaindb);
            if (GlobalVariable::$web3Result != 0){
                $web3_mancc = GlobalVariable::$web3Result["_MaNCC"];
                $web3_mavungtrong = GlobalVariable::$web3Result["_MaVungTrong"];
                $web3_masp = GlobalVariable::$web3Result["_MASP"];
                $web3_mahd = GlobalVariable::$web3Result["_MAHD"];
                $web3_created_at = GlobalVariable::$web3Result["_created_at"];
                $web3_shelf_life = GlobalVariable::$web3Result["_shelf_life"];
                $today = \Carbon\Carbon::now();
                if ($web3_mancc != $block->madoanhnghiep){
                    return  view('warning',[
                        "title"=>"QR Code Đã Bị Can Thiệp!",
                        "content"=>"Chúng tôi phát hiện QR code của bạn đã bị can thiệp."
                    ]);
                }else{
                    if ($web3_shelf_life > $today){
//                            return  view('warning',[
//                                "title"=>"Sản Phẩm Hết Hạn Sử Dụng!",
//                                "content"=>"Sản phẩm này đã hết hạn sử dụng vào ngày ".$web3_shelf_life.". \n Bạn vui lòng liên hệ nhân viên để được giúp đỡ!"
//                            ]);
                    }else{
                        $id_product = $blockchaindb->id_product;
                        $id_bill = $blockchaindb->id_bill_received;

                        $billreceiveds = DB::select('select * from billreceiveds where id ='.$id_bill);
                        $salerooms = Salesroom::all();


                        $info_product = DB::select('select products.id as id_product, products.name as name_product, products.description as des_product, products.detail as detail_product, products.thumb , farmers.mavungtrong, seedsuppliers.madoanhnghiep
                                              from  products, crops, farmers, seedsandseedlings, seedsuppliers
                                              where products.id_crop = crops.id and crops.id_farmer = farmers.id and crops.id_seedandseedling = seedsandseedlings.id
                                                    and seedsandseedlings.id_seedsupplier = seedsuppliers.id and products.id = '.$id_product);


                        return view('userView',[
                            'number'=>$number,
                            'blockUser'=>$blockchaindb,
                            'info'=>$info_product[0],
                            'billreceiveds'=>$billreceiveds,
                            'salerooms'=>$salerooms
                        ]);
                    }

                    $id_product = $block->id_product;
                    $id_bill = $block->id_bill_received;

                    $billreceiveds = DB::select('select * from billreceiveds where id ='.$id_bill);
                    $salerooms = Salesroom::all();


                    $info_product = DB::select('select products.id as id_product, products.name as name_product, products.description as des_product, products.detail as detail_product, products.thumb , farmers.mavungtrong, seedsuppliers.madoanhnghiep
                                              from  products, crops, farmers, seedsandseedlings, seedsuppliers
                                              where products.id_crop = crops.id and crops.id_farmer = farmers.id and crops.id_seedandseedling = seedsandseedlings.id
                                                    and seedsandseedlings.id_seedsupplier = seedsuppliers.id and products.id = '.$id_product);


                    return view('userView',[
                        'number'=>$number,
                        'blockUser'=>$block,
                        'info'=>$info_product[0],
                        'billreceiveds'=>$billreceiveds,
                        'salerooms'=>$salerooms
                    ]);
                }
            }
        } else{
            return view('warning',[
                'title'=>"Cánh Báo Mã QR Code Đã Bị Can Thiệp!",
                'content'=>"Chúng tôi phát hiện mã QR code bạn vừa quét là giả hoặc đã bị can thiệp sửa đổi. Chúng tôi không có bất kỳ trách nhiệm nào đối với sản phẩm này. Nếu bạn muốn mua sản phẩm của chúng tôi vui lòng truy cập trang web nongsanvinhlongsv.click hoặc đến trực tiếp chuỗi cửa hàng của chúng tôi. Xin cảm ơn!",
            ]);
        }
    }
}
