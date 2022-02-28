<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Models\ProductTypes;
use App\Models\Categories;
use App\Models\Products;
use App\Models\ProductImage;
use App\Models\Specifications;
use App\Http\Requests\StoreProductRequest;
use App\Services\ImgurService;
use File;
use Validator;
use DB;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=Products::where('status',1)->paginate(5);
        return response()->json($product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category=Categories::where('status',1)->get();
        $producttype=ProductTypes::where('status',1)->get();
        return response()->json(['category'=>$category,'producttype'=>$producttype]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|min:2|max:255',
                'slug' => 'required|min:2|max:255|unique:product'
            ],
            [
                'required' => 'Tên danh mục không được để trống',
                'min' => 'Tên danh mục phải từ  2-255 ký tự',
                'max' => 'Tên danh mục phải từ  2-255 ký tự',
                'unique' => 'Tên đã được sử dụng'
            ]
        );
            $dulieu = $request->only(['name','description', 'slug', 'quantity','price','promotion','idCategory','idProductType','status']);

            if($request->hasFile('file')){
                $files=$request->file;
                $product=Products::create($dulieu);
                $idproduct=$product->id;
                $specification = new Specifications();
                $specification->product_id = $idproduct;
                $specification->screen = $request->screen;
                $specification = $request->only(['screen', 'operating_system', 'rear_camera', 'front_camera', 'cpu', 'ram', 'internal_memory', 'sim', 'battery', 'design']);
                $specification['product_id'] = $idproduct;
                Specifications::create($specification);
                foreach($files as $key => $value){
                    $file_type= $value->getMimeType();
                    if($file_type == 'image/png'|| $file_type=='image/jpg'|| $file_type=='image/jpeg'||$file_type=='image/gif'){
                        $file_url = ImgurService::uploadImage($value->getRealPath());
                        $product_image['url']=$file_url;
                        $product_image['idProduct']=$idproduct;
                        ProductImage::create($product_image);
                    }else{
                        return response()->json(['message' => 'file bạn chọn không phải là hình']);
                    }
                }
            }else{
                return response()->json(['message' => 'Ban chua chon hinh']);
            }
            return response()->json(['message' => 'Thêm thành công']);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $product = Products::find($id);
        return response()->json(['product' => $product],200);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $this->validate($request,
            [
                'name' => 'required|min:2|max:255',
                'slug' => 'required|min:2|max:255',
                'description' => 'required|min:2',
                'quantity' => 'required|numeric',
                'price' => 'required|numeric',
                'promotion' => 'numeric',
            ],
            [
                'required' => ':attribute không được bỏ trống',
                'min' => ':attribute tối thiểu có 2 ký tự',
                'max' => ':attribute tối đa có 255 ký tự',
                'numeric' => ':attribute phải là một số ',
                'unique' => ':attribute đã tồn tại trong hệ thống'
            ],
            [
                'name' => 'Tên sản phẩm',
                'description' => 'Mô tả sản phẩm',
                'quantity' => 'Số lượng sản phẩm',
                'price' => 'Đơn giá sản phẩm',
                'promotion' => 'Giá khuyến mại',
            ]
        );
            $product = Products::find($id);
            $idproduct=$product->id;
            $data = $request->all();
            $image=ProductImage::where('idProduct',$id)->get();
            if($request->hasFile('file')){
                foreach ($image as $key => $giatri) {
                    $giatri->delete();
                }
                $files= $request->file;
                foreach($files as $value){
                    $file_type= $value->getMimeType();
                    if($file_type == 'image/png'|| $file_type=='image/jpg'|| $file_type=='image/jpeg'||$file_type=='image/gif'){
                        $file_url = ImgurService::uploadImage($value->getRealPath());
                        $product_image['url']=$file_url;
                        $product_image['idProduct']=$idproduct;
                        ProductImage::create($product_image);
                    }else{
                        return response()->json(['message'=>'File bạn chon không phải là hình ảnh']);
                    }
                }
            }
            $product->update($data);
            return response()->json(['message' => 'Đã sửa thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $product =Products::find($id);
            $specification = Specifications::where('product_id', $id);
            $specification->delete();
            $image=ProductImage::where('idProduct',$id)->get();
            if(count($product->ProductImg)===0){
                if($product->delete()){
                return response()->json(['result' => 'Đã xóa thành công loại sản phẩm có id '.$id],200);
                }
            }else{
                foreach ($image as $key => $value) {
                    $value->delete();
                }
                if($product->delete()){
                return response()->json(['result' => 'Đã xóa thành công loại sản phẩm có id '.$id],200);
                }
            }
    }
    public function getProductDetail($slug){
        $productdetail=Products::where('slug', $slug)->with('Category')->with('ProductType')->with('ProductImg')->with('Specification')->get();
        if(empty($productdetail)){
            return response()->json(['error'=>'Khong tim thay san pham']);
        }
        foreach ($productdetail as $key => $value) {
            $value->Category;
            $value->ProductType;
            $value->ProductImg;
            $value->Specification;
            $data[$key]=$value;
        }
        return response()->json(['product'=> $productdetail]);
    }

    public function getProductDetailById($id){
        $productdetail=Products::where('id', $id)->with('Category')->with('ProductType')->with('ProductImg')->with('Specification')->get();
        if(empty($productdetail)){
            return response()->json(['error'=>'Khong tim thay san pham']);
        }
        return response()->json($productdetail);
    }

    public function getAllProduct(){
        $product = Products::with('Category')->with('ProductType')->with('ProductImg')->get();
        return response()->json(['product'=> $product]);
    }
    public function getRandomProduct(){
        $product = Products::inRandomOrder()->limit(4)->get();
        $data=[];
        foreach ($product as $key => $value) {
            $value->Category;
            $value->ProductType;
            $value->ProductImg;

            $data[$key]=$value;
        }
        return response()->json(['product'=> $data]);
    }

    public function getAllProductPaging($numberItem)
    {
        if ($sort = \Request::get('sort')) {
            $products = Products::where('status', 1)->orderBy('price', $sort)->paginate($numberItem);
            if (empty($products)) {
                return response()->json(['error' => 'Khong tim thay san pham']);
            }
            foreach ($products as $key => $value) {
                $value->ProductImg;
                $category = Categories::find($value->idCategory);
                $productType = ProductTypes::find($value->idProductType);
                $categoryName = $category['name'];
                $productTypeName = $productType['name'];
                $products[$key]['categoryName'] = $categoryName;
                $products[$key]['productTypeName'] = $productTypeName;
                $products[$key] = $value;
            }
        } else {
            $products = Products::where('status', 1)->paginate($numberItem);
            if (empty($products)) {
                return response()->json(['error' => 'Khong tim thay san pham']);
            }
            foreach ($products as $key => $value) {
                $value->ProductImg;
                $category = Categories::find($value->idCategory);
                $productType = ProductTypes::find($value->idProductType);
                $categoryName = $category['name'];
                $productTypeName = $productType['name'];
                $products[$key]['categoryName'] = $categoryName;
                $products[$key]['productTypeName'] = $productTypeName;
                $products[$key] = $value;
            }
        }
        return response()->json($products);

    }
    public function searchProduct($numberItem){
        if ($search = \Request::get('q')) {

            $products = Products::where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            })->paginate($numberItem);
            foreach ($products as $key => $value) {
                $value->ProductImg;
                $value->Category;
                $value->ProductType;
                $products[$key] = $value;
            }
            return $products;
        }

    }
    public function getProductImgByProduct(){
        $product = Products::with('ProductImg')->get();
        return response()->json(['product'=>$product]);
    }

    public function getProductByCategoryId($categoryId,  $numberItem){
        if ($sort = \Request::get('sort')) {
            $products = Products::where('idCategory', $categoryId)->orderBy('price', $sort)->paginate($numberItem);
            if (empty($products)) {
                return response()->json(['error' => 'Khong tim thay san pham']);
            }
            foreach ($products as $key => $value) {
                $value->ProductImg;
                $value->Category;
                $value->ProductType;
                $products[$key] = $value;
            }
        }else{
            $products = Products::where('idCategory', $categoryId)->paginate($numberItem);
            if (empty($products)) {
                return response()->json(['error' => 'Khong tim thay san pham']);
            }
            foreach ($products as $key => $value) {
                $value->ProductImg;
                $products[$key] = $value;
            }
        }
        return response()->json(['product'=> $products]);
    }

    
    public function searchProductCustomer($numberItem){
        if ($sort = \Request::get('sort')) {
            if ($search = \Request::get('keyword')) {
                $products = Products::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%$search%");
                })->orderBy('price', $sort)->paginate($numberItem);
                foreach ($products as $key => $value) {
                    $value->ProductImg;
                    $value->Category;
                    $value->ProductType;
                    $products[$key] = $value;
                }
            }
            return response()->json(['product'=> $products]);
        }else{
            if ($search = \Request::get('keyword')) {
                $products = Products::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%$search%");
                })->paginate($numberItem);
                foreach ($products as $key => $value) {
                    $value->ProductImg;
                    $value->Category;
                    $value->ProductType;
                    $products[$key] = $value;
                }
                return response()->json(['product'=> $products]);
            }
        }

    }

    public function getProductByProductTypeId($productTypeId, $numberItem){
        if ($sort = \Request::get('sort')) {
            $products = Products::where('idProductType', $productTypeId)->orderBy('price', $sort)->paginate($numberItem);
            if (empty($products)) {
                return response()->json(['error' => 'Khong tim thay san pham']);
            }
            foreach ($products as $key => $value) {
                $value->ProductImg;
                $value->Category;
                $value->ProductType;
                $products[$key] = $value;
            }
        }else{
            $products = Products::where('idProductType', $productTypeId)->paginate($numberItem);
            if (empty($products)) {
                return response()->json(['error' => 'Khong tim thay san pham']);
            }
            foreach ($products as $key => $value) {
                $value->ProductImg;
                $products[$key] = $value;
            }
        }
        return response()->json(['product'=> $products]);
    }
}
