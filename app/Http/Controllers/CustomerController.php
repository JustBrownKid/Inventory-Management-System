<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function index()
    {
        return view('customerCreate');
    }


    public function store()
  {
   
    $data = request()->validate([
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'address' => 'required',
    ]);

    $customer = new Customer();
    $customer->name = $data['name'];
    $customer->phone = $data['phone'];
    $customer->email = $data['email'];
    $customer->address = $data['address'];
    $customer->save();

    return redirect()->route('customer')->with('success', 'Customer has been successfully added!');
  }

  
  public function list()
  {
    $customers = Customer::all();
    return view('customerList', compact('customers'));
  }
 

  public function destroy($id)
  {
    $customer = Customer::find($id);
    if ($customer) {
        $customer->delete();
        return redirect()->route('customer.list')->with('success', 'Customer has been successfully deleted!');
    } else {
        return redirect()->route('customer.list')->with('error', 'Customer not found!');
    }
  }
  public function edit($id)
  {
    $customer = Customer::find($id);
    if ($customer) {
        return view('customerEdit', compact('customer'));
    } else {
        return redirect()->route('customer.list')->with('error', 'Customer not found!');
    }
  }

  
  public function update(Request $request, $id)
  {
    $data = $request->validate([
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'address' => 'required',
    ]); 

    $customer = Customer::find($id);
    if ($customer) {
        $customer->name = $data['name'];
        $customer->phone = $data['phone'];
        $customer->email = $data['email'];
        $customer->address = $data['address'];
        $customer->save();

        return redirect()->route('customer.list')->with('success', 'Customer has been successfully updated!');
    } else {
        return redirect()->route('customer.list')->with('error', 'Customer not found!');
    }
  }
}
