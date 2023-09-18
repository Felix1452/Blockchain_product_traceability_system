<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\img_products;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductImgController extends Controller
{
    public function createImg(Product $product){
        return view('admin.products.addImgProduct', [
            'title' => 'Thêm ảnh cho sản phẩm '. $product->name,
            'products' => $product,
            'imgProduct' => img_products::where('product_id',$product->id)
                ->orderByDesc('id')->get()
        ]);
    }

    public function storeImg(Request $request)
    {
        try {
            $img = (string)$request->input('thumb');
            if ($img!=''){
                img_products::create([
                    'product_id' => (string)$request->input('product_id'),
                    'thumb1' => $img
                ]);
                Session::flash('success', 'Thêm ảnh sản phẩm thành công !');
            }
            else
            {
                Session::flash('error', 'Ảnh trống!');
            }
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm ảnh thất bại');
        }
        return redirect()->back();
    }

    public function destroyImg(Request $request){
        try {
            $id = (int)$request->input('id');
            $productImg = img_products::where('id', $id)->first();
            $path = str_replace('storage','public', $productImg->thumb1);
            Storage::delete($path);
            $productImg->delete();
            return response()->json([
                'error' =>false,
                'message' => 'Xóa anh thành công!'
            ]);
        }catch (\Exception $err){
            return response()->json(['error'=>true]);
        }
    }
}
