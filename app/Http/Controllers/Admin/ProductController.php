<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Product\ProductService;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(){
        $products = $this->productService->get();
        return view('admin.products.list',[
            "title"=>"Sản Phẩm",
            "products"=>$products,
        ]);
    }
    public function create(){
        $crops = $this->productService->getCrop();
        $menus = $this->productService->getMenu();
        return view('admin.products.add',[
            "title"=>"Sản Phẩm",
            "menus"=>$menus,
            "crops"=>$crops
        ]);
    }

    public function store(Request $request){
        if(session()->get('perr') == 1){
            $result = $this->productService->create($request);
            if($result){
                return redirect()->route('admin.products.list');
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
    }

    public function show(Product $product){
        $crops = $this->productService->getCrop();
        $menus = $this->productService->getMenu();
//        dd($cropId);
        return view('admin.products.edit',[
            'title' => 'Chỉnh sửa Sản Phẩm: '. $product->name,
            'crops' => $crops,
            "menus"=>$menus,
            "product"=>$product
        ]);
    }

    public function update(Request $request, Product $product)
    {
//        dd($request->input());
        $result = $this->productService->update($request, $product);
        if($result){
            return redirect()->route('admin.products.list');
        }
        else
            return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->productService->destroy($request);
        if($result){
            return response()->json([
                'error' =>false,
                'message' => 'Xóa Sản Phẩm thành công!'
            ]);
        }
        return response()->json(['error'=>true]);
    }
}
