<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;

class ProductCategoryController extends Controller
{
    public function all(Request $request){
        $id = $request->get('id');
        $name = $request->get('name');
        $limit = $request->get('limit');
        $show_product = $request->get('show_product');

        if ($id) {
            $category = ProductCategory::with(['products'])->find($id);

            if ($category) {
                return ResponseFormatter::success([
                    $category, 'Data Kategori Berhasil Diambil'
                ]);
            }else{
                return ResponseFormatter::error(null, 'Data Kategori Tidak Ada');
            }
        }

        $category = ProductCategory::query();
        if ($name) {
            $category->where('name','LIKE','%'.$name.'%');
        }
        if ($show_product) {
            $category->with(['products']);
        }
        return ResponseFormatter::success($category->paginate($limit), 'Data Kategori Berhasil Diambil');
    }
}

