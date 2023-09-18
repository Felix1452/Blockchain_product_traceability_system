<?php

namespace App\Http\Services\Billreceived;

use App\Helpers\GlobalVariable;
use App\Http\BlockChain\Blockchain;
use App\Http\Services\BlockChainService;
use App\Models\Billreceived;
use App\Models\Crop;
use App\Models\Farmer;
use App\Models\Product;
use App\Models\Salesroom;
use App\Models\Seedsandseedling;
use Hamcrest\Util;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Web3\Contract;
use Web3\Utils;
use Web3\Web3;

class BillreceivedService
{

    public $blockchainService;
    public function __construct(BlockChainService $blockChainService)
    {
        $this->blockchainService = $blockChainService;

    }

    public function get(){
        $result = DB::select('select billreceiveds.id, billreceiveds.quantity, billreceiveds.price, billreceiveds.total_price, billreceiveds.list_saleroom, billreceiveds.shelf_life, billreceiveds.created_at, products.name, billreceiveds.thumb as qrcode
                                    from products, billreceiveds
                                    where billreceiveds.id_product = products.id');
        return $result;
    }

    public function getSaleroom(){
        return Salesroom::all();
    }

    public function getProduct(){
        return Product::all();
    }

    public function getFirstProduct(){
        return DB::select('select products.id, products.thumb, seedsuppliers.madoanhnghiep, farmers.mavungtrong, farmers.tencoso , seedsuppliers.tencoso as name_seed
                                 from products, seedsuppliers, farmers, crops, seedsandseedlings
                                 where products.id_crop = crops.id and crops.id_farmer = farmers.id and crops.id_seedandseedling = seedsandseedlings.id and seedsandseedlings.id_seedsupplier = seedsuppliers.id
                                 ORDER BY id ASC LIMIT 1');
    }

    public function getProductValue($id_product){
        return $info_product = DB::select('select products.id as id_product, farmers.mavungtrong, farmers.tenchunhatrong, seedsuppliers.madoanhnghiep, seedsuppliers.tencoso, products.thumb
                                              from  products, crops, farmers, seedsandseedlings, seedsuppliers
                                              where products.id_crop = crops.id and crops.id_farmer = farmers.id and crops.id_seedandseedling = seedsandseedlings.id
                                                    and seedsandseedlings.id_seedsupplier = seedsuppliers.id and products.id = '.$id_product);
    }

    public function getId($id){
        $result = DB::select('select *
                                    from  billreceiveds
                                    where id = '.$id);
        return $result;
    }

    public function create($request){


        try {
            GlobalVariable::$errorCheckBill = 0;
            GlobalVariable::$countBill = 0;
            GlobalVariable::$reultBill = "";

            ##------------------------------CREATE Billreceived in MySQL-----------------------------------
            $products = DB::select('select * from  products ');
            $arrsaleroom = array();
            for ($i= 0; $i < count($request->input('saleroom')); $i++){
                array_push($arrsaleroom, $request->input('saleroom')[$i]);
            }
            $arrSaleroom = implode(",",$arrsaleroom);
            foreach ($products as $product){
                if ($product->id == $request->input("id_product")){
                    $price = $product->price;
                }
            }

            $total_price = $price * $request->input("quantity");
            Billreceived::create([
                'quantity'=>$request->input("quantity"),
                'price'=>$price,
                'total_price'=>$total_price,
                'id_product'=>$request->input("id_product"),
                'list_saleroom'=>$arrSaleroom,
                'shelf_life'=>$request->input("shelf_life")
            ]);

            // update quantity product --- active



            $products_id = DB::select('select * from  products where id =  '.$request->input("id_product"));

            $quantity_id = $products_id[0]->quantity;
            $quantity_id = (int)$quantity_id + (int)$request->input("quantity");
            Product::where('id',$request->input("id_product"))->update(array(
                'quantity'=>$quantity_id,
                'active'=>1
            ));

            $id_billreceived = DB::select('SELECT * FROM `billreceiveds` ORDER BY id DESC  LIMIT 1 ');
            $id = $id_billreceived[0]->id;
            $id_product = $request->input("id_product");
            $created_at = $id_billreceived[0]->created_at;
            $shelf_life = $id_billreceived[0]->shelf_life;

            ## get all infomation in product

//            dd("2");
            $info_product = DB::select('select products.id as id_product, products.name as name_product, products.description as des_product, products.detail as detail_product, products.thumb as thumb_product,
                                                    farmers.mavungtrong, farmers.thumb as thumb_farmer, farmers.tencoso as tencoso_farmer, farmers.mota as mota_farmer, farmers.diachi as diachi_nv, farmers.sodienthoai as sodienthoai_nv,
                                                    seedsuppliers.madoanhnghiep, seedsuppliers.thumb as thumb_seedsupplier, seedsuppliers.madoanhnghiep as madoanhnghiep_seedsupplier, seedsuppliers.tencoso as tencoso_seed, seedsuppliers.mota as mota_seedsupplier, seedsuppliers.diachi as diachi_seedsupplier, seedsuppliers.sodienthoai as sodienthoai_seedsupplier,
                                                    seedsandseedlings.thumb as thumb_seedsandseedling, seedsandseedlings.description as description_seedsandseedling, seedsandseedlings.name as name_seedsandseedling, seedsandseedlings.detail as detail_seedsandseedling,
                                                    crops.thumb as thumb_crop, crops.detail as detail_crop, crops.description as description_crop, crops.name as name_crop
                                              from  products, crops, farmers, seedsandseedlings, seedsuppliers
                                              where products.id_crop = crops.id and crops.id_farmer = farmers.id and crops.id_seedandseedling = seedsandseedlings.id
                                                    and seedsandseedlings.id_seedsupplier = seedsuppliers.id and products.id = '.$id_product);


//            dd($info_product);

//            dd("1");
            //nha cung cap
            $madoanhnghiep = $info_product[0]->madoanhnghiep_seedsupplier;
            $tenncc = $info_product[0]->tencoso_seed;
            $thumb_ncc = $info_product[0]->thumb_seedsupplier;
            $mota_ncc = $info_product[0]->mota_seedsupplier;
            $diachi_ncc = $info_product[0]->diachi_seedsupplier;
            $sodienthoai_ncc = $info_product[0]->sodienthoai_seedsupplier;
            //nha vuon
            $mavungtrong = $info_product[0]->mavungtrong;
            $tennv = $info_product[0]->tencoso_farmer;
            $thumb_nv = $info_product[0]->thumb_farmer;
            $mota_nv = $info_product[0]->mota_farmer;
            $sodienthoai_nv =$info_product[0]->sodienthoai_nv;
            $diachi_nv =$info_product[0]->diachi_nv;
            //cay giong
            $thumb_cg = $info_product[0]->thumb_seedsandseedling;
            $mota_cg = $info_product[0]->description_seedsandseedling;
            $ten_cg = $info_product[0]->name_seedsandseedling;
            $chitiet_cg = $info_product[0]->detail_seedsandseedling;
            //cay trong
            $chitiet_ct = $info_product[0]->detail_crop;
            $mota_ct = $info_product[0]->description_crop;
            $thumb_ct = $info_product[0]->thumb_crop;
            $ten_ct = $info_product[0]->name_crop;
            //san pham
            $ten_sp = $info_product[0]->name_product;
            $mota_sp = $info_product[0]->des_product;
            $chitiet_sp = $info_product[0]->detail_product;
            $thumb_sp = $info_product[0]->thumb_product;

            $arrayValue = [ "madoanhnghiep"=>$madoanhnghiep, "tenncc"=>$tenncc, "thumb_ncc"=> $thumb_ncc, "mota_ncc"=>$mota_ncc, "diachi_ncc"=>$diachi_ncc, "sodienthoai_ncc"=>$sodienthoai_ncc,
                            "ten_cg"=>$ten_cg,"mota_cg"=>$mota_cg,"thumb_cg"=>$thumb_cg,"chitiet_cg"=>$chitiet_cg,
                            "mavungtrong"=> $mavungtrong, "tennv" =>$tennv, "thumb_nv"=>$thumb_nv, "mota_nv"=>$mota_nv, "sodienthoai_nv"=>$sodienthoai_nv, "diachi_nv"=>$diachi_nv,
                            "chitiet_ct"=>$chitiet_ct,"mota_ct"=>$mota_ct,"thumb_ct"=>$thumb_ct,"ten_ct"=>$ten_ct,
                            "id_product"=>$id_product, "ten_sp"=>$ten_sp,"mota_sp"=>$mota_sp, "chitiet_sp"=>$chitiet_sp,"thumb_sp"=>$thumb_sp,
                            "id_bill"=>$id,"created_at"=>$created_at,"shelf_life"=>$shelf_life,
                          ];

//            dd($arrayValue);

            ##--------------------------Create BlockChain-------------------------------
            $web3 = new Web3('http://127.0.0.1:7545');
//            dd($web3->provider);
            $contractABI = json_decode(file_get_contents(resource_path('contracts/abi.json')), true);
            $contractAddress = '0x26b2Cc501dD330d0e162c20D52f0D1A697A50AE3';
            $contract = new Contract($web3->provider, $contractABI);
            $contract->at($contractAddress);
//            dd($contract);

            $web3->eth->accounts(function ($err, $accounts) use ($contract, $arrayValue, $id_product, $id, $contractAddress) {
                if ($err !== null) {
                    // Handle error
                    echo 'Error: ' . $err->getMessage();
                    return;
                }
                $senderAddress = '0x50b9f1fa42f0e81Fd3d360ADBD57ec4D2BF936cB';
                $senderPrivateKey = '0x6899a051e112b5fc676724268560f17c561bf6968734803d759acccfe35f37e8';

                $fromAddress = $accounts[0];  // Use the first account for the transaction
                $toAddress = $accounts[1];


                $contract->call('countBill', function ($err, $result) use ($contract,$arrayValue, $id_product, $id, $fromAddress, $contractAddress ) {
                    if ($err !== null) {
                        // Handle error
                        echo 'Error: ' . $err->getMessage();
                    }else{
//                    echo 'Số khối: ' . $result;
                        $countBlock = json_decode(json_encode($result[0]->value));
                        //-----------------------------------------Add Block-------------------------------------
                        if ($countBlock != 0){
//                            dd($countBlock);
                            $a = DB::select('select * from blockchaindbs');
                            $hoangChainLast = json_decode($a[0]->blockchain);
                            $hoangChain = new Blockchain(2);
                            $hoangChain->chain = $hoangChainLast->chain;
                            $hoangChain->difficulty = $hoangChainLast->difficulty;


                            $value = $hoangChain->getLastBlock()->hash;

                            $hoangChain->addBlock($arrayValue);
                            $valid = $hoangChain->isValid();

                            if ($valid == false){
                                GlobalVariable::$errorCheckBill = 1;
                                Session::flash("error",'Chuỗi khối bị can thiệp');
                                return false;
                            }

                            $valueAdd = $hoangChain->getLastBlock()->hash;
                            $minevar = $hoangChain->getLastBlock()->mineVar."phuc";
                            $valueAdd = $valueAdd.$minevar;

//                            dd($valueAdd);

                            $contract->call('arrBlockChain', (int)($countBlock-1) , function ($err, $result)  {
                                if ($err !== null) {
                                    // Handle error
                                    echo 'Error: ' . $err->getMessage();
//                                    GlobalVariable::$errorCheckBill = 1;
                                }else{
                                    GlobalVariable::$reultBill = $result;
                                }


                            });
//                            dd(GlobalVariable::$reultBill);
                            if (GlobalVariable::$errorCheckBill == 0){
                                $compare = $value.GlobalVariable::$reultBill["_minevar"];
//                                dd($value ."----".GlobalVariable::$reultBill["_minevar"] );
                                if (GlobalVariable::$reultBill["_hash"] == md5($compare)){
                                    $contract->send('DangKyBill', md5($valueAdd), $minevar, [
                                        'from' => $fromAddress,
                                        'to' => $contractAddress,
                                        'gas' => 2000000,
                                        'gasPrice' => 1000000000, // Optional: Specify gas price in Wei
                                    ], function ($err, $result) {
                                        if ($err !== null) {
                                            // Handle error
                                            echo 'Error: ' . $err->getMessage();
                                        }
                                    });
//                                    dd("haha");

                                    ## ---------------------------- Generate QR code and Save Off-Chain in MySQL  -----------------------------
                                    $blockString = md5($hoangChain->getLastBlock()->hash);
                                    $blockData = json_encode($hoangChain->getLastBlock()->data);

                                    $result = $this->blockchainService->update($a[0]->id, json_encode($hoangChain));
                                    Product::where('id',$id_product)->update(array(
                                        'block'=>$blockString,
                                        'block_number'=>(count($hoangChain->chain)-1)
                                    ));


                                    $qrCodePath = public_path('public/qrcode/qrcode' . (count($hoangChain->chain) - 1) . '.png');


                                    $image = \QrCode::format('png')
                                        ->size(200)
                                        ->generate("https://8d36-115-77-37-15.ngrok-free.app/checkBlock/".(count($hoangChain->chain)-1)."/".$blockString);


                                    $output_file = '/img/qr-code/img-'.(count($hoangChain->chain)-1).'.png';
                                    Storage::disk('public')->put($output_file, $image);

                                    $img_link = '/storage/img/qr-code/img-'. (count($hoangChain->chain)-1) . '.png';

                                    Billreceived::where('id',$id)->update(array(
                                        'thumb'=>$img_link
                                    ));
                                }
                                else{
                                    Session::flash("error",'Chuỗi khối Cuối bị can thiệp');
                                    GlobalVariable::$errorCheckBill = 1;
                                    return false;
                                }
                            }else{
                                Session::flash("error",'Lấy dữ liệu On-chain gặp lỗi!');
                                GlobalVariable::$errorCheckBill = 1;
                                return false;
                            }
                        }
                        else{
//                            dd("count block = 0");
                            $hoangChain = new Blockchain(2);
                            $hoangChain->addBlock($arrayValue);
                            $valid = $hoangChain->isValid();
                            if ($valid != true ){
                                Session::flash("error",'Chuỗi khối bị can thiệp');
                                GlobalVariable::$errorCheckBill = 1;
                                return false;
                            }

//                            dd("success");

                            $value = $hoangChain->getLastBlock()->hash;
                            $minevar = $hoangChain->getLastBlock()->mineVar."phuc";
                            $valueAdd = $value.$minevar;

                            $this->blockchainService->create(json_encode($hoangChain));
//                            dd($hoangChain);

                            $contract->call('DangKyBill', "aaa", "aaa", function ($err, $result) {
                                if ($err !== null) {
                                    // Handle error
                                    echo 'Error: ' . $err->getMessage();
                                }
                            });

                            $contract->send('DangKyBill', "aaa", "aaa",[
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

                            $contract->send('DangKyBill', md5($valueAdd), $minevar, [
                                'from' => $fromAddress,
                                'to' => $contractAddress,
                                'gas' => 2000000,
                                'gasPrice' => 1000000000, // Optional: Specify gas price in Wei
                            ], function ($err, $result) {
                                if ($err !== null) {
                                    // Handle error
                                    echo 'Error: ' . $err->getMessage();
                                }
                            });

            ## ---------------------------- Generate QR code and Save Off-Chain in MySQL ----------------------------------
                            $blockString = md5($hoangChain->getLastBlock()->hash);
                            $blockData = json_encode($hoangChain->getLastBlock()->data);

                            Product::where('id',$id_product)->update(array(
                                'block'=>$blockString,
                                'block_number'=>(count($hoangChain->chain)-1)
                            ));

                            $qrCodePath = public_path('public/qrcode/qrcode' . (count($hoangChain->chain) - 1) . '.png');
                            $image = \QrCode::format('png')
                                ->size(200)
                                ->generate("https://8d36-115-77-37-15.ngrok-free.app/checkBlock/".(count($hoangChain->chain)-1)."/".$blockString);

                            $output_file = '/img/qr-code/img-'.(count($hoangChain->chain)-1).'.png';
                            Storage::disk('public')->put($output_file, $image);


                            $img_link = '/storage/img/qr-code/img-'.(count($hoangChain->chain)-1).'.png';

                            Billreceived::where('id',$id)->update(array(
                                'thumb'=>$img_link
                            ));
                        }
                    }
                });
            });
            return true;
        }catch (\Exception $err){
            Session::flash("error",'Lỗi');
            return false;
        }
    }

    public function update($request, $billreceived){
        try {
            $arrsaleroom= array();
            for ($i= 0; $i < count($request->input('saleroom')); $i++){
                array_push($arrsaleroom, $request->input('saleroom')[$i]);
            }
            $arrSaleroom = implode(",",$arrsaleroom);

            $billreceived->list_saleroom = $arrSaleroom;

            $billreceived->save();
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
        $billreceived = Billreceived::where('id', $id)->first();
        if ($billreceived) {
            $billreceived->delete();
            return true;
        }
        return false;
    }
}
