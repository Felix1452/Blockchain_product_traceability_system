<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use App\Http\Services\Menu\MenuService;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this -> menuService = $menuService;
    }

    public function create(){
        return view('admin.menu.add', [
            'title' => 'Thêm Danh Mục Mới',
            'parent_id' =>$this -> menuService ->getParentMenu()
        ]);
    }

    public function store(CreateFormRequest $request){
//        dd($request->input());

        $result = $this->menuService->create($request);
        if($result){
            return redirect('/admin/menus/list');
        }
        else
            return false;

    }

    public function index(){
        return view('admin.menu.list',[
            'title' => 'Danh sách danh mục mới nhất ',
            'menus' => $this->menuService->getAll()
        ]);
    }

    public function show(Menu $menu){
        return view('admin.menu.edit', [
            'title' => 'Chỉnh sửa danh mục: '. $menu->name,
            'menus' => $menu,
            'parent_id' =>$this -> menuService ->getParentMenu()
        ]);
    }


    public function update(Menu $menu, CreateFormRequest $request){
        $result = $this->menuService->update($request, $menu);
        if($result){
            return redirect('/admin/menus/list');
        }
        else
            return false;
    }

    public function destroy(Request $request)
    {
        $result = $this->menuService->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công danh mục'
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }
}
