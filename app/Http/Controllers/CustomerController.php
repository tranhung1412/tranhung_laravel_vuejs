<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Auth;
use Validator;
class CustomerController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Customer::all();
        return response()->json($customer);
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'phone' => 'required|numeric',
                'address' => 'required|min:2|max:255',

            ],
            [
                'required' => ':attribute không được bỏ trống',
                'min' => ':attribute tối thiểu có 2 ký tự',
                'max' => ':attribute tối đa có 255 ký tự',
                'numeric' => ':attribute phải là một số ',
                'email'=>':attribute phải là định dạng email',
            ],
            [
                'phone' => 'Số điện thoại',
                'address' => 'Địa chỉ giao hàng',
            ]
        );
        $data = $request->all();
//        $data['idUser'] = Auth::user()->id;
        $customer = Customer::where('idUser', $data['idUser'])->where('active', 1)->first();
        if (!empty($customer)){
            if ($data['active'] != 0){
                $customer->active = 0;
                $customer->save();
            }
        }
        $customer=Customer::create($data);
        return response()->json(['message' => 'Thêm thành công', 'customer' => $customer]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data= $request->all();
        $allCustomer = Customer::where('idUser', $data['idUser'])->where('active', 1)->first();
        if (!empty($allCustomer)){
            $allCustomer->active = 0;
            $allCustomer->save();
        }
        $customer = Customer::find($id);
        $data = $request->all();
        $data['active'] = 1;
        if ($customer->update($data)) {
            return response()->json(['message' => 'Cập nhật thành công'], 200);
        } else {
            return response()->json(['message' => 'Cập nhật thất bại'], 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function getCustomerAddressActive()
    {
        $customer = Customer::where('active', 1)->get();
        return response()->json($customer);
        //
    }
}
