<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\ProductTypes;
use App\Models\Products;
use App\Models\ProductImage;
use App\Http\Requests\StoreCategoryRequest;
use Validator;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Categories::where('status', 1)->get();
        return response()->json($category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public function getAllCategoryPaging($numberItem)
    {
        $category = Categories::paginate($numberItem);
        return response()->json($category);
    }

    public function searchCategory($numberItem)
    {
        if ($search = \Request::get('q')) {

            $category = Categories::where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            })->paginate($numberItem);
            return $category;
        }
    }

    public function getAllCategory()
    {
        $category = Categories::where('status', 1)->with('productType')->get();
        return response()->json(['category' => $category]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|min:2|max:255|unique:category',
                'slug' => 'required|min:2|max:255|unique:category'
            ],
            [
                'required' => 'Tên danh mục không được để trống',
                'min' => 'Tên danh mục phải từ  2-255 ký tự',
                'max' => 'Tên danh mục phải từ  2-255 ký tự',
                'unique' => 'Tên đã được sử dụng'
            ]
        );
        $data = $request->all();
        if (Categories::create($data)) {
            $categories = Categories::all();
            return response()->json(['message' => 'Thêm thành công', 'Categories' => $categories]);
        } else {
            return response()->json(['message' => 'Thêm thất bại']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $category = Categories::find($id);
        return response()->json($category, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,
            [
                'name' => 'required|min:2|max:255|unique:category',
                'slug' => 'required|min:2|max:255'
            ],
            [
                'required' => 'Tên danh mục không được để trống',
                'min' => 'Tên danh mục phải từ  2-255 ký tự',
                'max' => 'Tên danh mục phải từ  2-255 ký tự',
                'unique' => 'Tên đã được sử dụng'
            ]
        );
        $category = Categories::find($id);
        $data = $request->all();
        if ($category->update($data)) {
            return response()->json(['message' => 'Cập nhật thành công'], 200);
        } else {
            return response()->json(['message' => 'Cập nhật thất bại'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Categories::find($id);
        $productType = ProductTypes::where('idCategory', $id)->get();
        $product = Products::where('idCategory', $id)->get();
        if (count($category->productType) === 0) {
            $category->delete();
            $status = 1;
            return response()->json(['status' => $status]);
        } else {
            $status = 0;
            return response()->json(['status' => $status]);
        }
    }

    public function getProductType()
    {
        $category = Categories::all();
        $data = [];
        foreach ($category as $key => $value) {
            $value->productType;
            $data[$key] = $value;
        }
        return response()->json(['category' => $data]);
    }

    public function getCategoryBySlug($slug)
    {
        $category = Categories::where('slug', $slug)->get();
        return response()->json($category);
    }
    public function getProductByProductTypeId($productTypeId){
        $products = Products::where('idProductType', $productTypeId)->get();
        if(empty($products)){
            return response()->json(['error'=>'Khong tim thay san pham']);
        }
        $data=[];
        foreach ($products as $key => $value) {
            $value->Category;
            $value->ProductType;
            $value->ProductImg;
            $data[$key]=$value;
        }
        return response()->json(['product'=> $data]);
    }
}
