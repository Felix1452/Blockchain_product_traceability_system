<?php

namespace App\Http\Controllers;


use App\Http\Services\Cart\CartService;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Product\ProductService;
use App\Http\Services\Slider\SliderService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    protected $slider;
    protected $menu;
    protected $product;
    protected $cartService;

    public function __construct(SliderService $slider, MenuService $menu, ProductService $product, CartService $cartService)
    {
        $this->slider = $slider;
        $this->menu = $menu;
        $this->product = $product;
        $this->cartService =$cartService;
    }

    public function index(){
        $day = Carbon::now()->dayOfYear;
        return view('home',[
            'title' => 'HUY PHÚC SHOP',
            'sliders' =>$this->slider->show(),
            'menus' => $this->menu->show(),
            'products' => $this->product->getmain(),
            'day' => $day
        ]);
    }


    public function loadProduct(Request $request)
    {
        $page = $request->input('page', 0);
        $result = $this->product->getmain($page);
        if ( count($result) != 0) {
            $html = view('products.list', ['products' => $result ])->render();
            return response()->json([ 'html' => $html ]);
        }
        return response()->json(['html' => '' ]);
    }

    public function test(){
        return view('test',[]);
    }

    public function about(){
        return view('about',[
            'title' => 'Thông tin chúng tôi'
        ]);
    }

    public function contact(){
        return view('contact',[
            'title' => 'Liên hệ'
        ]);
    }

    public function sendMess(Request $request){
        Mail::send('mail.sendUsMess', ['customer' => $request], function ($m) use ($request) {
            $m->to('lethanhuy1005@gmail.com')->subject('Phản hồi từ khách hàng!');
        });
        return redirect()->back();
    }

    public function viewSearch(){
        return view('search',[
            'title' => 'Tim kiem',
            'result' => null
        ]);
    }

    public function search(Request $request){

        // Get the search value from the request
        $search = $request->input('search');
        $now = Carbon::now()->dayOfYear;
        if ($search == ""){
            return view('search', [
                'title' => 'Search',
                'search' => $search,
                'dayOfYear' => $now
            ]);
        }
        // Search in the title and body columns from the posts table
        $posts = Product::where('name', 'LIKE', "%{$search}%")
            ->where('active',1)
            ->orderByDesc('created_at')
            ->get();
        // Return the search view with the resluts compacted

        return view('search', [
            'title' => 'Search',
            'search' => $search,
            'result' => $posts,
            'dayOfYear' => $now
        ]);
    }

}
