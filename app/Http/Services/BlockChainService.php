<?php

namespace App\Http\Services;
use App\Models\Blockchaindb;
use Illuminate\Support\Facades\Session;

class BlockChainService
{
    public function getBlockchain(){

    }

    public function create($blockchainString){
        Blockchaindb::create([
            'blockchain'=>(string)$blockchainString,
        ]);
    }

    public function update($id, $blockchainString){
        try {
            Blockchaindb::where('id',$id)->update(['blockchain' => $blockchainString]);
            Session::flash('success', 'Cập nhật thành công !');
        }
        catch (\Exception $err){
            Session::flash('error','Lỗi');
            return false;
        }
        return true;
    }


}
