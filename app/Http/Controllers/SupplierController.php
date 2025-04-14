<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    //
    public function index()
    {
        return view('supplier.supplierCreate');
    }


    public function store()
  {
   
    $data = request()->validate([
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'address' => 'required',
    ]);

    $supplier = new Supplier();
    $supplier->name = $data['name'];
    $supplier->phone = $data['phone'];
    $supplier->email = $data['email'];
    $supplier->address = $data['address'];
    $supplier->save();

    return redirect()->route('supplier')->with('success', 'Supplier has been successfully added!');
  }

  
  public function list()
  {
    $customers = Supplier::all();
    return view('supplier.supplierList', compact('customers'));
  }
 

  public function destroy($id)
  {
    $supplier = Supplier::find($id);
    if ($supplier) {
        $supplier->delete();
        return redirect()->route('supplier.list')->with('success', 'Supplier has been successfully deleted!');
    } else {
        return redirect()->route('supplier.list')->with('error', 'Supplier not found!');
    }
  }
  public function edit($id)
  {
    $supplier = Supplier::find($id);
    if ($supplier) {
        return view('supplier.supplierEdit', compact('supplier'));
    } else {
        return redirect()->route('supplier.list')->with('error', 'Supplier not found!');
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

    $supplier = Supplier::find($id);
    if ($supplier) {
        $supplier->name = $data['name'];
        $supplier->phone = $data['phone'];
        $supplier->email = $data['email'];
        $supplier->address = $data['address'];
        $supplier->save();

        return redirect()->route('supplier.list')->with('success', 'Supplier has been successfully updated!');
    } else {
        return redirect()->route('supplier.list')->with('error', 'Supplier not found!');
    }
  }
}
