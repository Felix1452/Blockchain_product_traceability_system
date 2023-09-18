<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\GlobalVariable;
use App\Http\BlockChain\Blockchain;
use App\Http\Controllers\Controller;
use App\Models\Billreceived;
use App\Models\Product;
use App\Models\Timecheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Web3\Contract;
use Web3\Web3;

class AccuracyController extends Controller
{
    public function index(){



//        return view("admin.checkaccuracys.danger",[
//            "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
//            "title"=>"CHƯA CÓ DỮ LIỆU ",
//            "content"=>"Hệ Thống Chưa Có Dữ Liệu!"
//        ]);

//        $timeDB = Timecheck::all();

//        $a = md5("123");
//        $b = $a.md5("Phuchuynh@1452");
////        if ($a )
//        dd($b);
        $timeDB = Timecheck::all();

        if (time() - $timeDB[0]->time > 180){
            return view("admin.checkaccuracys.checkview",[
                "img"=>"https://cdn.vectorstock.com/i/1000x1000/68/73/cyber-security-concept-vector-24506873.webp",
                "time"=>time() - $timeDB[0]->time
            ]);
        }else{
            return view("admin.checkaccuracys.success",[
                "img"=>"https://cdn.vectorstock.com/i/1000x1000/45/86/cyber-security-concept-with-padlock-and-check-vector-24224586.webp",
                "time"=>time() - $timeDB[0]->time
            ]);
        }
    }


    public function FixError(){
        try {
            try {
                $migrationFile = '2023_06_14_114601_drop_all_tables.php'; // Replace with your migration file name

                // Run the specific migration
                Artisan::call('migrate', [
                    '--path' => 'database/migrations/' . $migrationFile,
                    '--force' => true, // Optional: Force the migration to run in production
                ]);

                // Get the output of the migration command
                $output = Artisan::output();

                // Display the output
                echo "SQL file imported successfully!";

                echo $output;
            } catch (\Exception $e) {
                // Handle any exceptions that occur during the migration
                echo "Migration failed: " . $e->getMessage();
            }


            //------------------------------------------Get Path---------------

            $directoryPath = storage_path('app/backup');

            $files = File::files($directoryPath);

            if (!empty($files)) {
                $latestFile = collect($files)->sortByDesc(function ($file) {
                    return $file->getMTime();
                })->first();

                $latestFilePath = $latestFile->getPathname();

                echo $latestFilePath;
            } else {
                echo "No files found in the directory.";
            }


            $filePath = $latestFilePath;

            // Get the SQL file content
            $sql = file_get_contents($filePath);

            // Run the SQL queries
            DB::connection()->getPdo()->exec($sql);
        }catch (\Exception $e) {
            // Handle any exceptions that occur during the migration
            echo "Migration failed: " . $e->getMessage();
        }

        $web3 = new Web3('http://127.0.0.1:7545');
//            dd($web3->provider);
        $contractABI = json_decode(file_get_contents(resource_path('contracts/abi.json')), true);
        $contractAddress = '0x26b2Cc501dD330d0e162c20D52f0D1A697A50AE3';
        $contract = new Contract($web3->provider, $contractABI);
        $contract->at($contractAddress);

        if (Schema::hasTable("blockchaindbs") == false){
            try {
                $migrationFile = '2023_06_14_114601_drop_all_tables.php'; // Replace with your migration file name

                // Run the specific migration
                Artisan::call('migrate', [
                    '--path' => 'database/migrations/' . $migrationFile,
                    '--force' => true, // Optional: Force the migration to run in production
                ]);

                // Get the output of the migration command
                $output = Artisan::output();

                // Display the output
                echo "SQL file imported successfully!";

                echo $output;
            } catch (\Exception $e) {
                // Handle any exceptions that occur during the migration
                echo "Migration failed: " . $e->getMessage();
            }


            //------------------------------------------Get Path---------------

            $directoryPath = storage_path('app/backup');

            $files = File::files($directoryPath);

            if (!empty($files)) {
                $latestFile = collect($files)->sortByDesc(function ($file) {
                    return $file->getMTime();
                })->first();

                $latestFilePath = $latestFile->getPathname();

                echo $latestFilePath;
            } else {
                echo "No files found in the directory.";
            }


            $filePath = $latestFilePath;

            // Get the SQL file content
            $sql = file_get_contents($filePath);

            // Run the SQL queries
            DB::connection()->getPdo()->exec($sql);

            $a = DB::select('select * from blockchaindbs');
            if (sizeof($a) == 0){
                $contract->call('countBill', function ($err, $result) use ($contract, $contractAddress) {
                    if ($err !== null) {
                        // Handle error
                        echo 'Error: ' . $err->getMessage();
                    } else {
                        GlobalVariable::$countBill = $result;
                    }
                });


                return view("admin.checkaccuracys.danger",[
                    "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                    "title"=>"CHƯA CÓ DỮ LIỆU ",
                    "content"=>"Hệ Thống Chưa Có Dữ Liệu!"
                ]);
            }
            $hoangChainLast = json_decode($a[0]->blockchain);
            $hoangChain = new Blockchain(2);
            $hoangChain->chain = $hoangChainLast->chain;
            $hoangChain->difficulty = $hoangChainLast->difficulty;

            $valid = $hoangChain->isValid();


            //----------------------------------Xác thực bill------------------------

            if($valid){
                for ($i = (sizeof($hoangChain->chain) - 1); $i > 1 ; $i--) {
//            dd(md5($hoangChain->chain[2]->hash));
                    $web3->eth->accounts(function ($err, $accounts) use ($contract, $hoangChain, $i, $contractAddress) {
                        if ($err !== null) {
                            // Handle error
                            echo 'Error: ' . $err->getMessage();
                            return;
                        }
                        $senderAddress = '0x50b9f1fa42f0e81Fd3d360ADBD57ec4D2BF936cB';
                        $senderPrivateKey = '0x6899a051e112b5fc676724268560f17c561bf6968734803d759acccfe35f37e8';


                        $contract->call('countBill', function ($err, $result) use ($contract, $hoangChain, $i, $contractAddress) {
                            if ($err !== null) {
                                // Handle error
                                echo 'Error: ' . $err->getMessage();
                            } else {
                                //                    echo 'Số khối: ' . $result;
                                $countBlock = json_decode(json_encode($result[0]->value));
                                if ($countBlock != sizeof($hoangChain->chain)) {
                                    GlobalVariable::$accuracyBill++;
                                }
                                //-----------------------------------------Check Block-------------------------------------
                                if ($countBlock != 0 && GlobalVariable::$accuracyBill == 0) {
                                    //                            dd(1);
                                    $contract->call('arrBlockChain', (int)($i), function ($err, $result) use ($hoangChain, $i) {
                                        if ($err !== null) {
                                            // Handle error
                                            echo 'Error: ' . $err->getMessage();
                                            GlobalVariable::$errorCallBill = 1;
                                        }

                                        //                                    dd($result["_hash"]);
//                            dd($result["_hash"]);
                                        if (md5($hoangChain->chain[$i]->hash) != $result["_hash"]) {
                                            GlobalVariable::$accuracyBill++;
//                                            dd("0");
                                        }
                                    });
                                }

                            }
                        });
                    });

//                dd(GlobalVariable::$accuracyBill);

                }
                if (GlobalVariable::$accuracyBill == 0){
                    $sale = DB::select('select * from salesroomchains');
                    $saleChainLast = json_decode($sale[0]->blockchain_salesroom);
                    $saleroomChain = new Blockchain(2);
                    $saleroomChain->chain = $saleChainLast->chain;
                    $saleroomChain->difficulty = $saleChainLast->difficulty;

                    $validSale = $saleroomChain->isValid();
                    if ($validSale){
                        for ($j = (sizeof($saleroomChain->chain) - 1); $j > 1 ; $j--) {
//            dd(md5($hoangChain->chain[2]->hash));
                            $web3->eth->accounts(function ($err, $accounts) use ($contract, $saleroomChain, $j, $contractAddress) {
                                if ($err !== null) {
                                    // Handle error
                                    echo 'Error: ' . $err->getMessage();
                                    return;
                                }
                                $senderAddress = '0x50b9f1fa42f0e81Fd3d360ADBD57ec4D2BF936cB';
                                $senderPrivateKey = '0x6899a051e112b5fc676724268560f17c561bf6968734803d759acccfe35f37e8';


                                $contract->call('countSaleroom', function ($err, $result) use ($contract, $saleroomChain, $j, $contractAddress) {
                                    if ($err !== null) {
                                        // Handle error
                                        echo 'Error: ' . $err->getMessage();
                                    } else {
                                        //                    echo 'Số khối: ' . $result;
                                        $countBlockSale = json_decode(json_encode($result[0]->value));
                                        if ($countBlockSale != sizeof($saleroomChain->chain)) {
                                            GlobalVariable::$accuracySalesroom++;
                                        }
                                        //-----------------------------------------Check Block-------------------------------------
                                        if ($countBlockSale != 0 && GlobalVariable::$accuracyBill == 0) {
                                            //                            dd(1);
                                            $contract->call('arrSaleroom', (int)($j), function ($err, $result) use ($saleroomChain, $j) {
                                                if ($err !== null) {
                                                    // Handle error
                                                    echo 'Error: ' . $err->getMessage();
                                                    GlobalVariable::$errorCallSale = 1;
                                                }

                                                //                                    dd($result["_hash"]);
//                            dd($result["_hash"]);
                                                if (md5($saleroomChain->chain[$j]->hash) != $result["_hash"]) {
                                                    GlobalVariable::$accuracySalesroom++;
//                                            dd("0");
                                                }
                                            });
                                        }

                                    }
                                });
                            });

//                dd(GlobalVariable::$accuracyBill);

                        }

                        if (GlobalVariable::$accuracySalesroom == 0){
                            $timeDB = Timecheck::all();

                            Timecheck::where('id',$timeDB[0]->id)->update(array(
                                'time'=>time()
                            ));

                            $timeDB = Timecheck::all();

                            return view("admin.checkaccuracys.success",[
                                "img"=>"https://cdn.vectorstock.com/i/1000x1000/45/86/cyber-security-concept-with-padlock-and-check-vector-24224586.webp",
                                "time"=>time() - $timeDB[0]->time
                            ]);
                        }else{
                            return view("admin.checkaccuracys.danger",[
                                "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                                "title"=>"Chuỗi Khối Salesroom MySQL không đúng với Blockchain!"
                            ]);
                        }
                    }else{
                        return view("admin.checkaccuracys.danger",[
                            "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                            "title"=>"DỮ LIỆU ĐÃ BỊ SỬA ĐỔI",
                            "content"=>"Chuỗi khối Salesroom ở MySQL đã bị sửa đổi!"
                        ]);
                    }
                }else{
                    return view("admin.checkaccuracys.danger",[
                        "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                        "title"=>"DỮ LIỆU ĐÃ BỊ SỬA ĐỔI",
                        "content"=>"Chuỗi Khối Thông Tin Sản Phẩm Không Giống Với Blockchain!"
                    ]);
                }
            }else{
                return view("admin.checkaccuracys.danger",[
                    "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                    "title"=>"DỮ LIỆU ĐÃ BỊ SỬA ĐỔI",
                    "content"=>"Chuỗi Khối Thông Tin Sản Phẩm Ở MySQL Đã Bị Sửa Đổi"
                ]);
            }
        }else{
            $a = DB::select('select * from blockchaindbs');
            if (sizeof($a) == 0){
                $contract->call('countBill', function ($err, $result) use ($contract, $contractAddress) {
                    if ($err !== null) {
                        // Handle error
                        echo 'Error: ' . $err->getMessage();
                    } else {
                        GlobalVariable::$countBill = $result;
                    }
                });


                return view("admin.checkaccuracys.danger",[
                    "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                    "title"=>"CHƯA CÓ DỮ LIỆU ",
                    "content"=>"Hệ Thống Chưa Có Dữ Liệu!"
                ]);
            }
            $hoangChainLast = json_decode($a[0]->blockchain);
            $hoangChain = new Blockchain(2);
            $hoangChain->chain = $hoangChainLast->chain;
            $hoangChain->difficulty = $hoangChainLast->difficulty;

            $valid = $hoangChain->isValid();


            //----------------------------------Xác thực bill------------------------

            if($valid){
                for ($i = (sizeof($hoangChain->chain) - 1); $i > 1 ; $i--) {
//            dd(md5($hoangChain->chain[2]->hash));
                    $web3->eth->accounts(function ($err, $accounts) use ($contract, $hoangChain, $i, $contractAddress) {
                        if ($err !== null) {
                            // Handle error
                            echo 'Error: ' . $err->getMessage();
                            return;
                        }
                        $senderAddress = '0x50b9f1fa42f0e81Fd3d360ADBD57ec4D2BF936cB';
                        $senderPrivateKey = '0x6899a051e112b5fc676724268560f17c561bf6968734803d759acccfe35f37e8';


                        $contract->call('countBill', function ($err, $result) use ($contract, $hoangChain, $i, $contractAddress) {
                            if ($err !== null) {
                                // Handle error
                                echo 'Error: ' . $err->getMessage();
                            } else {
                                //                    echo 'Số khối: ' . $result;
                                $countBlock = json_decode(json_encode($result[0]->value));
                                if ($countBlock != sizeof($hoangChain->chain)) {
                                    GlobalVariable::$accuracyBill++;
                                }
                                //-----------------------------------------Check Block-------------------------------------
                                if ($countBlock != 0 && GlobalVariable::$accuracyBill == 0) {
                                    //                            dd(1);
                                    $contract->call('arrBlockChain', (int)($i), function ($err, $result) use ($hoangChain, $i) {
                                        if ($err !== null) {
                                            // Handle error
                                            echo 'Error: ' . $err->getMessage();
                                            GlobalVariable::$errorCallBill = 1;
                                        }

                                        //                                    dd($result["_hash"]);
//                            dd($result["_hash"]);
                                        if (md5($hoangChain->chain[$i]->hash) != $result["_hash"]) {
                                            GlobalVariable::$accuracyBill++;
//                                            dd("0");
                                        }
                                    });
                                }

                            }
                        });
                    });

//                dd(GlobalVariable::$accuracyBill);

                }
                if (GlobalVariable::$accuracyBill == 0){
                    $sale = DB::select('select * from salesroomchains');
                    $saleChainLast = json_decode($sale[0]->blockchain_salesroom);
                    $saleroomChain = new Blockchain(2);
                    $saleroomChain->chain = $saleChainLast->chain;
                    $saleroomChain->difficulty = $saleChainLast->difficulty;

                    $validSale = $saleroomChain->isValid();
                    if ($validSale){
                        for ($j = (sizeof($saleroomChain->chain) - 1); $j > 1 ; $j--) {
//            dd(md5($hoangChain->chain[2]->hash));
                            $web3->eth->accounts(function ($err, $accounts) use ($contract, $saleroomChain, $j, $contractAddress) {
                                if ($err !== null) {
                                    // Handle error
                                    echo 'Error: ' . $err->getMessage();
                                    return;
                                }
                                $senderAddress = '0x50b9f1fa42f0e81Fd3d360ADBD57ec4D2BF936cB';
                                $senderPrivateKey = '0x6899a051e112b5fc676724268560f17c561bf6968734803d759acccfe35f37e8';


                                $contract->call('countSaleroom', function ($err, $result) use ($contract, $saleroomChain, $j, $contractAddress) {
                                    if ($err !== null) {
                                        // Handle error
                                        echo 'Error: ' . $err->getMessage();
                                    } else {
                                        //                    echo 'Số khối: ' . $result;
                                        $countBlockSale = json_decode(json_encode($result[0]->value));
                                        if ($countBlockSale != sizeof($saleroomChain->chain)) {
                                            GlobalVariable::$accuracySalesroom++;
                                        }
                                        //-----------------------------------------Check Block-------------------------------------
                                        if ($countBlockSale != 0 && GlobalVariable::$accuracyBill == 0) {
                                            //                            dd(1);
                                            $contract->call('arrSaleroom', (int)($j), function ($err, $result) use ($saleroomChain, $j) {
                                                if ($err !== null) {
                                                    // Handle error
                                                    echo 'Error: ' . $err->getMessage();
                                                    GlobalVariable::$errorCallSale = 1;
                                                }

                                                //                                    dd($result["_hash"]);
//                            dd($result["_hash"]);
                                                if (md5($saleroomChain->chain[$j]->hash) != $result["_hash"]) {
                                                    GlobalVariable::$accuracySalesroom++;
//                                            dd("0");
                                                }
                                            });
                                        }

                                    }
                                });
                            });

//                dd(GlobalVariable::$accuracyBill);

                        }

                        if (GlobalVariable::$accuracySalesroom == 0){
                            $timeDB = Timecheck::all();

                            Timecheck::where('id',$timeDB[0]->id)->update(array(
                                'time'=>time()
                            ));

                            $timeDB = Timecheck::all();

                            return view("admin.checkaccuracys.success",[
                                "img"=>"https://cdn.vectorstock.com/i/1000x1000/45/86/cyber-security-concept-with-padlock-and-check-vector-24224586.webp",
                                "time"=>time() - $timeDB[0]->time
                            ]);
                        }else{
                            return view("admin.checkaccuracys.danger",[
                                "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                                "title"=>"Chuỗi Khối Salesroom MySQL không đúng với Blockchain!"
                            ]);
                        }
                    }else{
                        return view("admin.checkaccuracys.danger",[
                            "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                            "title"=>"DỮ LIỆU ĐÃ BỊ SỬA ĐỔI",
                            "content"=>"Chuỗi khối Salesroom ở MySQL đã bị sửa đổi!"
                        ]);
                    }
                }else{
                    return view("admin.checkaccuracys.danger",[
                        "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                        "title"=>"DỮ LIỆU ĐÃ BỊ SỬA ĐỔI",
                        "content"=>"Chuỗi Khối Thông Tin Sản Phẩm Không Giống Với Blockchain!"
                    ]);
                }
            }else{
                return view("admin.checkaccuracys.danger",[
                    "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                    "title"=>"DỮ LIỆU ĐÃ BỊ SỬA ĐỔI",
                    "content"=>"Chuỗi Khối Thông Tin Sản Phẩm Ở MySQL Đã Bị Sửa Đổi"
                ]);
            }
        }
    }

    public function checkData(){
        $web3 = new Web3('http://127.0.0.1:7545');
//            dd($web3->provider);
        $contractABI = json_decode(file_get_contents(resource_path('contracts/abi.json')), true);
        $contractAddress = '0x26b2Cc501dD330d0e162c20D52f0D1A697A50AE3';
        $contract = new Contract($web3->provider, $contractABI);
        $contract->at($contractAddress);

        if (Schema::hasTable("blockchaindbs") == false){
            try {
                $migrationFile = '2023_06_14_114601_drop_all_tables.php'; // Replace with your migration file name

                // Run the specific migration
                Artisan::call('migrate', [
                    '--path' => 'database/migrations/' . $migrationFile,
                    '--force' => true, // Optional: Force the migration to run in production
                ]);

                // Get the output of the migration command
                $output = Artisan::output();

                // Display the output
                echo "SQL file imported successfully!";

                echo $output;
            } catch (\Exception $e) {
                // Handle any exceptions that occur during the migration
                echo "Migration failed: " . $e->getMessage();
            }


            //------------------------------------------Get Path---------------

            $directoryPath = storage_path('app/backup');

            $files = File::files($directoryPath);

            if (!empty($files)) {
                $latestFile = collect($files)->sortByDesc(function ($file) {
                    return $file->getMTime();
                })->first();

                $latestFilePath = $latestFile->getPathname();

                echo $latestFilePath;
            } else {
                echo "No files found in the directory.";
            }


            $filePath = $latestFilePath;

            // Get the SQL file content
            $sql = file_get_contents($filePath);

            // Run the SQL queries
            DB::connection()->getPdo()->exec($sql);

            $a = DB::select('select * from blockchaindbs');
            if (sizeof($a) == 0){
                $contract->call('countBill', function ($err, $result) use ($contract, $contractAddress) {
                    if ($err !== null) {
                        // Handle error
                        echo 'Error: ' . $err->getMessage();
                    } else {
                        GlobalVariable::$countBill = $result;
                    }
                });


                return view("admin.checkaccuracys.danger",[
                    "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                    "title"=>"CHƯA CÓ DỮ LIỆU ",
                    "content"=>"Hệ Thống Chưa Có Dữ Liệu!"
                ]);
            }
            $hoangChainLast = json_decode($a[0]->blockchain);
            $hoangChain = new Blockchain(2);
            $hoangChain->chain = $hoangChainLast->chain;
            $hoangChain->difficulty = $hoangChainLast->difficulty;

            $valid = $hoangChain->isValid();


            //----------------------------------Xác thực bill------------------------

            if($valid){
                for ($i = (sizeof($hoangChain->chain) - 1); $i > 1 ; $i--) {
//            dd(md5($hoangChain->chain[2]->hash));
                    $web3->eth->accounts(function ($err, $accounts) use ($contract, $hoangChain, $i, $contractAddress) {
                        if ($err !== null) {
                            // Handle error
                            echo 'Error: ' . $err->getMessage();
                            return;
                        }
                        $senderAddress = '0x50b9f1fa42f0e81Fd3d360ADBD57ec4D2BF936cB';
                        $senderPrivateKey = '0x6899a051e112b5fc676724268560f17c561bf6968734803d759acccfe35f37e8';


                        $contract->call('countBill', function ($err, $result) use ($contract, $hoangChain, $i, $contractAddress) {
                            if ($err !== null) {
                                // Handle error
                                echo 'Error: ' . $err->getMessage();
                            } else {
                                //                    echo 'Số khối: ' . $result;
                                $countBlock = json_decode(json_encode($result[0]->value));
                                if ($countBlock != sizeof($hoangChain->chain)) {
                                    GlobalVariable::$accuracyBill++;
                                }
                                //-----------------------------------------Check Block-------------------------------------
                                if ($countBlock != 0 && GlobalVariable::$accuracyBill == 0) {
                                    //                            dd(1);
                                    $contract->call('arrBlockChain', (int)($i), function ($err, $result) use ($hoangChain, $i) {
                                        if ($err !== null) {
                                            // Handle error
                                            echo 'Error: ' . $err->getMessage();
                                            GlobalVariable::$errorCallBill = 1;
                                        }

                                        //                                    dd($result["_hash"]);
//                            dd($result["_hash"]);
                                        if (md5($hoangChain->chain[$i]->hash.$result["_minevar"]) != $result["_hash"]) {
                                            GlobalVariable::$accuracyBill++;
//                                            dd("0");
                                        }
                                    });
                                }

                            }
                        });
                    });

//                dd(GlobalVariable::$accuracyBill);

                }
                if (GlobalVariable::$accuracyBill == 0){
                    $sale = DB::select('select * from salesroomchains');
                    $saleChainLast = json_decode($sale[0]->blockchain_salesroom);
                    $saleroomChain = new Blockchain(2);
                    $saleroomChain->chain = $saleChainLast->chain;
                    $saleroomChain->difficulty = $saleChainLast->difficulty;

                    $validSale = $saleroomChain->isValid();
                    if ($validSale){
                        for ($j = (sizeof($saleroomChain->chain) - 1); $j > 1 ; $j--) {
//            dd(md5($hoangChain->chain[2]->hash));
                            $web3->eth->accounts(function ($err, $accounts) use ($contract, $saleroomChain, $j, $contractAddress) {
                                if ($err !== null) {
                                    // Handle error
                                    echo 'Error: ' . $err->getMessage();
                                    return;
                                }
                                $senderAddress = '0x50b9f1fa42f0e81Fd3d360ADBD57ec4D2BF936cB';
                                $senderPrivateKey = '0x6899a051e112b5fc676724268560f17c561bf6968734803d759acccfe35f37e8';


                                $contract->call('countSaleroom', function ($err, $result) use ($contract, $saleroomChain, $j, $contractAddress) {
                                    if ($err !== null) {
                                        // Handle error
                                        echo 'Error: ' . $err->getMessage();
                                    } else {
                                        //                    echo 'Số khối: ' . $result;
                                        $countBlockSale = json_decode(json_encode($result[0]->value));
                                        if ($countBlockSale != sizeof($saleroomChain->chain)) {
                                            GlobalVariable::$accuracySalesroom++;
                                        }
                                        //-----------------------------------------Check Block-------------------------------------
                                        if ($countBlockSale != 0 && GlobalVariable::$accuracyBill == 0) {
                                            //                            dd(1);
                                            $contract->call('arrSaleroom', (int)($j), function ($err, $result) use ($saleroomChain, $j) {
                                                if ($err !== null) {
                                                    // Handle error
                                                    echo 'Error: ' . $err->getMessage();
                                                    GlobalVariable::$errorCallSale = 1;
                                                }

                                                //                                    dd($result["_hash"]);
//                            dd($result["_hash"]);
                                                if (md5($saleroomChain->chain[$j]->hash.$result["_minevar"]) != $result["_hash"]) {
                                                    GlobalVariable::$accuracySalesroom++;
//                                            dd("0");
                                                }
                                            });
                                        }

                                    }
                                });
                            });

//                dd(GlobalVariable::$accuracyBill);

                        }

                        if (GlobalVariable::$accuracySalesroom == 0){
                            $timeDB = Timecheck::all();

                            Timecheck::where('id',$timeDB[0]->id)->update(array(
                                'time'=>time()
                            ));

                            $timeDB = Timecheck::all();

                            return view("admin.checkaccuracys.success",[
                                "img"=>"https://cdn.vectorstock.com/i/1000x1000/45/86/cyber-security-concept-with-padlock-and-check-vector-24224586.webp",
                                "time"=>time() - $timeDB[0]->time
                            ]);
                        }else{
                            return view("admin.checkaccuracys.danger",[
                                "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                                "title"=>"Chuỗi Khối Salesroom MySQL không đúng với Blockchain!"
                            ]);
                        }
                    }else{
                        return view("admin.checkaccuracys.danger",[
                            "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                            "title"=>"DỮ LIỆU ĐÃ BỊ SỬA ĐỔI",
                            "content"=>"Chuỗi khối Salesroom ở MySQL đã bị sửa đổi!"
                        ]);
                    }
                }else{
                    return view("admin.checkaccuracys.danger",[
                        "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                        "title"=>"DỮ LIỆU ĐÃ BỊ SỬA ĐỔI",
                        "content"=>"Chuỗi Khối Thông Tin Sản Phẩm Không Giống Với Blockchain!"
                    ]);
                }
            }else{
                return view("admin.checkaccuracys.danger",[
                    "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                    "title"=>"DỮ LIỆU ĐÃ BỊ SỬA ĐỔI",
                    "content"=>"Chuỗi Khối Thông Tin Sản Phẩm Ở MySQL Đã Bị Sửa Đổi"
                ]);
            }
        }else{
            $a = DB::select('select * from blockchaindbs');
            if (sizeof($a) == 0){
                $contract->call('countBill', function ($err, $result) use ($contract, $contractAddress) {
                    if ($err !== null) {
                        // Handle error
                        echo 'Error: ' . $err->getMessage();
                    } else {
                        GlobalVariable::$countBill = $result;
                    }
                });

                if (GlobalVariable::$countBill[0]->value == 0){
                    $timeDB = Timecheck::all();

                    Timecheck::where('id',$timeDB[0]->id)->update(array(
                        'time'=>time()
                    ));

                    $timeDB = Timecheck::all();

                    return view("admin.checkaccuracys.success",[
                        "img"=>"https://cdn.vectorstock.com/i/1000x1000/45/86/cyber-security-concept-with-padlock-and-check-vector-24224586.webp",
                        "time"=>time() - $timeDB[0]->time
                    ]);
                }else{
                    return view("admin.checkaccuracys.danger",[
                        "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                        "title"=>"CHƯA CÓ DỮ LIỆU ",
                        "content"=>"Hệ Thống Chưa Có Dữ Liệu!"
                    ]);
                }
            }
            $hoangChainLast = json_decode($a[0]->blockchain);
            $hoangChain = new Blockchain(2);
            $hoangChain->chain = $hoangChainLast->chain;
            $hoangChain->difficulty = $hoangChainLast->difficulty;

            $valid = $hoangChain->isValid();


            //----------------------------------Xác thực bill------------------------

            if($valid){
                for ($i = (sizeof($hoangChain->chain) - 1); $i > 1 ; $i--) {
//            dd(md5($hoangChain->chain[2]->hash));
                    $web3->eth->accounts(function ($err, $accounts) use ($contract, $hoangChain, $i, $contractAddress) {
                        if ($err !== null) {
                            // Handle error
                            echo 'Error: ' . $err->getMessage();
                            return;
                        }
                        $senderAddress = '0x50b9f1fa42f0e81Fd3d360ADBD57ec4D2BF936cB';
                        $senderPrivateKey = '0x6899a051e112b5fc676724268560f17c561bf6968734803d759acccfe35f37e8';


                        $contract->call('countBill', function ($err, $result) use ($contract, $hoangChain, $i, $contractAddress) {
                            if ($err !== null) {
                                // Handle error
                                echo 'Error: ' . $err->getMessage();
                            } else {
                                //                    echo 'Số khối: ' . $result;
                                $countBlock = json_decode(json_encode($result[0]->value));
                                if ($countBlock != sizeof($hoangChain->chain)) {
                                    GlobalVariable::$accuracyBill++;
                                }
                                //-----------------------------------------Check Block-------------------------------------
                                if ($countBlock != 0 && GlobalVariable::$accuracyBill == 0) {
                                    //                            dd(1);
                                    $contract->call('arrBlockChain', (int)($i), function ($err, $result) use ($hoangChain, $i) {
                                        if ($err !== null) {
                                            // Handle error
                                            echo 'Error: ' . $err->getMessage();
                                            GlobalVariable::$errorCallBill = 1;
                                        }

                                        //                                    dd($result["_hash"]);
//                            dd($result["_hash"]);
                                        if (md5($hoangChain->chain[$i]->hash.$result["_minevar"]) != $result["_hash"]) {
                                            GlobalVariable::$accuracyBill++;
//                                            dd("0");
                                        }
                                    });
                                }

                            }
                        });
                    });

//                dd(GlobalVariable::$accuracyBill);

                }
                if (GlobalVariable::$accuracyBill == 0){
                    $sale = DB::select('select * from salesroomchains');
                    $saleChainLast = json_decode($sale[0]->blockchain_salesroom);
                    $saleroomChain = new Blockchain(2);
                    $saleroomChain->chain = $saleChainLast->chain;
                    $saleroomChain->difficulty = $saleChainLast->difficulty;

                    $validSale = $saleroomChain->isValid();
                    if ($validSale){
                        for ($j = (sizeof($saleroomChain->chain) - 1); $j > 1 ; $j--) {
//            dd(md5($hoangChain->chain[2]->hash));
                            $web3->eth->accounts(function ($err, $accounts) use ($contract, $saleroomChain, $j, $contractAddress) {
                                if ($err !== null) {
                                    // Handle error
                                    echo 'Error: ' . $err->getMessage();
                                    return;
                                }
                                $senderAddress = '0x50b9f1fa42f0e81Fd3d360ADBD57ec4D2BF936cB';
                                $senderPrivateKey = '0x6899a051e112b5fc676724268560f17c561bf6968734803d759acccfe35f37e8';


                                $contract->call('countSaleroom', function ($err, $result) use ($contract, $saleroomChain, $j, $contractAddress) {
                                    if ($err !== null) {
                                        // Handle error
                                        echo 'Error: ' . $err->getMessage();
                                    } else {
                                        //                    echo 'Số khối: ' . $result;
                                        $countBlockSale = json_decode(json_encode($result[0]->value));
                                        if ($countBlockSale != sizeof($saleroomChain->chain)) {
                                            GlobalVariable::$accuracySalesroom++;
                                        }
                                        //-----------------------------------------Check Block-------------------------------------
                                        if ($countBlockSale != 0 && GlobalVariable::$accuracyBill == 0) {
                                            //                            dd(1);
                                            $contract->call('arrSaleroom', (int)($j), function ($err, $result) use ($saleroomChain, $j) {
                                                if ($err !== null) {
                                                    // Handle error
                                                    echo 'Error: ' . $err->getMessage();
                                                    GlobalVariable::$errorCallSale = 1;
                                                }

                                                //                                    dd($result["_hash"]);
//                            dd($result["_hash"]);
                                                if (md5($saleroomChain->chain[$j]->hash.$result["_minevar"]) != $result["_hash"]) {
                                                    GlobalVariable::$accuracySalesroom++;
//                                            dd("0");
                                                }
                                            });
                                        }

                                    }
                                });
                            });

//                dd(GlobalVariable::$accuracyBill);

                        }

                        if (GlobalVariable::$accuracySalesroom == 0){
                            $timeDB = Timecheck::all();

                            Timecheck::where('id',$timeDB[0]->id)->update(array(
                                'time'=>time()
                            ));

                            $timeDB = Timecheck::all();

                            return view("admin.checkaccuracys.success",[
                                "img"=>"https://cdn.vectorstock.com/i/1000x1000/45/86/cyber-security-concept-with-padlock-and-check-vector-24224586.webp",
                                "time"=>time() - $timeDB[0]->time
                            ]);
                        }else{
                            return view("admin.checkaccuracys.danger",[
                                "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                                "title"=>"Chuỗi Khối Salesroom MySQL không đúng với Blockchain!"
                            ]);
                        }
                    }else{
                        return view("admin.checkaccuracys.danger",[
                            "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                            "title"=>"DỮ LIỆU ĐÃ BỊ SỬA ĐỔI",
                            "content"=>"Chuỗi khối Salesroom ở MySQL đã bị sửa đổi!"
                        ]);
                    }
                }else{
                    return view("admin.checkaccuracys.danger",[
                        "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                        "title"=>"DỮ LIỆU ĐÃ BỊ SỬA ĐỔI",
                        "content"=>"Chuỗi Khối Thông Tin Sản Phẩm Không Giống Với Blockchain!"
                    ]);
                }
            }else{
                return view("admin.checkaccuracys.danger",[
                    "img"=>"https://cdn.vectorstock.com/i/1000x1000/01/63/abstract-risk-warning-symbol-danger-concept-vector-47220163.webp",
                    "title"=>"DỮ LIỆU ĐÃ BỊ SỬA ĐỔI",
                    "content"=>"Chuỗi Khối Thông Tin Sản Phẩm Ở MySQL Đã Bị Sửa Đổi"
                ]);
            }
        }

    }
}
