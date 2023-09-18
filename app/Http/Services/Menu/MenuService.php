<?php


namespace App\Http\Services\Menu;


use App\Models\Menu;
use App\Models\Product;
use Faker\Core\Number;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Type\Integer;

class MenuService
{
    public function getParentMenu(){
        return Menu::where('parent_id',0)->get();
    }

    public function getAll(){
        return Menu::orderbyDesc('id')->paginate(10);
    }

    public function create($request){
        try {
            Menu::create([
//                dd($request->input())
//                $data => $request->input()

                'name' =>(string)$request->input('name'),
                'parent_id' =>(string)$request->input('parent_id'),
                'description' =>(string)$request->input('description'),
                'content' =>(string)$request->input('content'),
                'thumb' =>(string)$request->input('thumb'),
                'active' =>(string)$request->input('active')

            ]);

            Session::flash('success', 'Tạo danh mục thành công');

        }catch (\Exception $err){
            Session::flash('error',$err->getMessage());
            return false;
        }
        return true;
    }

    public function update($request, $menu){
        try {
            $check = Menu::where('parent_id',(string) $menu->id)->get();
            $menu->name = (string) $request->input('name');
            $menu->description = (string) $request->input('description');
            $menu->content = (string) $request->input('content');
            $menu->thumb = (string) $request->input('thumb');
            $menu->active = (string) $request->input('active');
            if ($check->isEmpty()){
                $menu->parent_id = (string) $request->input('parent_id');
            }else if($menu->parent_id != (string) $request->input('parent_id')){
                Session::flash('error', 'Danh mục chứa con không thể thay đổi !');
                return false;
            }
            $menu->save();
            Session::flash('success', 'Cập nhật danh mục thành công !');
            return true;
        }catch (\Exception $err){
            Session::flash('error','Lỗi cập nhật, xin vui lòng thử lại sau !');
            return false;
        }
    }

    public function destroy($request)
    {
        $id = (int)$request->input('id');
        $menu = Menu::where('id', $id)->first();
        if ($menu) {
            return Menu::where('id', $id)->orWhere('parent_id', $id)->delete();
        }
        return false;
    }

    public function show(){
        return Menu::where('parent_id',0)
            ->where('active',1)
            ->limit(3)
            ->get();
    }

    public function getIdParent($id){
        return Menu::where('id',$id)
            ->where('active',1)
            ->firstOrFail();
    }

    public function getIdChild($id){
        $a = Menu::where('parent_id',$id)
            ->where('active',1)
            ->get();
        return $a;
    }

    public function getAllMenus($id){
        return Menu::where('parent_id', $id)
            ->where('active',1)
            ->orWhere('id',$id)
            ->where('active',1)
            ->pluck('id')->toArray();
    }

    public function getProduct2($id, $request){
        $a = Product::whereIn('menu_id', $id)->where('price','>',0);

        if($request->input('price')){
            $a->orderBy('price',$request->input('price'));
        }
        return $a->orderByDesc('id')->paginate(12);
    }

    public function getProduct($menu, $request){
        $query = $menu->products()
            ->select('id', 'name', 'price', 'price_sale' ,'thumb', 'quantity')
            ->where('active', 1);
        if($request->input('price')){
            $query->orderBy('price',$request->input('price'));
        }
        return $query->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();
    }

    public function getProductFilter($menu, $request, $price){
        $price = (int)$price;
        if ($price>16000000){
            $query = Product::select('id', 'name', 'price', 'price_sale' ,'thumb', 'quantity')
                ->whereIn('menu_id', $menu)
                ->where('price','>',16000000)
                ->where('active', 1);
        }
        else{
            $price2 = $price - 4000000;
            $query = Product::select('id', 'name', 'price', 'price_sale' ,'thumb', 'quantity', 'menu_id')
                ->whereIn('menu_id', $menu)
                ->where('price','<',$price)
                ->where('price','>=',$price2)
                ->where('active', 1);
        }
        if($request->input('price')){
            $query->orderBy('price',$request->input('price'));
        }
        return $query->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();
    }
}
