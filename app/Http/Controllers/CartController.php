<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\User;
use App\Models\Categories;
use App\Models\Products;
use App\Models\ProductTypes;
use Cart;
use Auth;
use League\Flysystem\Exception;
use Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ShoppingMail;


class CartController extends Controller
{
    //  public function __construct(){
    //   $category=Categories::where('status',1)->get();
    //   $producttype=ProductTypes::where('status',1)->get();
    //   view()->share(['category'=>$category,'producttype'=>$producttype]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Cart::content();
        // //dd($cart);
        // //return view('client.pages.cart',compact('cart'));
        $data = Cart::total();
        return response()->json(['cart' => $cart, 'tong tien' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $data = $request->all();
        $customer = $data['customer'];
        $cart = $data['cart'];
        $data['code_order'] = 'order' . rand();
        $order['code_order'] = $data['code_order'];
        $order['idUser'] = $data['idUser'];
        $order['email'] = $data['email'];
        $order['name'] = $customer['name'];
        $order['address'] = $customer['address'];
        $order['phone'] = $customer['phone'];
        $order['total_price'] = $data['totalNum'];
        $order['status'] = 0;
        DB::beginTransaction();
        try {
            $result = Order::create($order);
            $idOrder = $result->id;
            $orderDetail = [];
            $orderDetails = [];
            foreach ($cart as $key => $value) {
            $orderDetail['idOrder'] = $idOrder;
            $orderDetail['idProduct'] = $value['product']['id'];
                $orderDetail['quantity'] = $value['quantity'];
                $product = Products::find($value['product']['id']);
                $product['quantity'] = $product['quantity'] - $orderDetail['quantity'];
                $product->save();
            $orderDetail['price'] = $value['product']['price'];
            $orderDetail['image'] = $value['product']['product_img'][0]['url'];
            $orderDetails[$key] = OrderDetail::create($orderDetail);

            }
            Mail::to($result->email)->send(new ShoppingMail($result, $orderDetails));
            DB::commit();
            return response()->json(['orderDetail'=> $orderDetail, 'cart' => $cart]);
        } catch (Exception $e) {

            DB::rollBack();
        }

    }

    public function addItem($id, $num){
        $product = Products::find($id);
        $product['quantity'] = $product['quantity'] - $num;
        if ($product['quantity'] < 0){
            return response()->json(['status'=> 'error']);
        }
        $product->save();
    }

    public function removeItem($id, $num){
        $product = Products::find($id);
        $product['quantity'] = $product['quantity'] + $num;
        $product->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //id la cot rowid khi addcart sinh ra
        if ($request->qty == 0) {
            return response()->json(['error' => 'Số lượng tối thiểu là 1 sản phẩm'], 200);
        } else {
            Cart::update($id, $request->qty);
            return response()->json(['result' => 'Đã cập số lượng sản phẩm thành công']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);
        return response()->json(['result' => 'Đã xóa thành công']);
    }

    public function addCart($id, Request $request)
    {
        $product = Products::find($id);
        if ($request->qty != 0) {
            $qty = $request->qty;
        } else {
            $qty = 1;
        }
        if ($product->promotion > 0) {
            $price = $product->promotion;
        } else {
            $price = $product->price;
        }
        $cart = $cart = ['id' => $id, 'name' => $product->name, 'qty' => $qty, 'price' => $price, 'options' => ['img' => $product->image]];
        Cart::add($cart);
        //$cartItems = Cart::content()->toArray();
        return response()->json(Cart::content());
    }

    public function checkout()
    {
        if (Auth::check() && Cart::count() > 0) {
            $user = Auth::user();
            $price = str_replace(',', '', Cart::total());
            return response()->json(['price' => $price, 'user' => $user]);
        } else {
            return response()->json(['message' => 'Ban phai dang nhap de thuc hien chuc nang nay va phai co 1 san phan trong gio hang']);
        }
    }
}
