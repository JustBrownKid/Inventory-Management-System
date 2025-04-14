@extends('layouts.master')

@section('title', 'Supplier Create') 

@section('content')

@if (session('success'))
    <div id="toast" class="fixed top-5 right-5 p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg shadow-lg transform transition-all opacity-100">
        <span class="font-medium">Success!</span> {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.classList.add('opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 500); 
            }
        }, 5000); 
    </script>
@endif
<div class="w-full bg-slate-500 p-3 text-white text-center ">
    <h1 class="text-2xl font-bold tracking-wide">Customer Information Create</h1>
</div>

<div class="container mx-auto p-6">
<form action="{{ route('supplier.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label class="block font-semibold text-gray-700">Supplier Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded px-3 py-2">
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block font-semibold text-gray-700">Phone Number</label>
        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 rounded px-3 py-2">
        @error('phone')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block font-semibold text-gray-700">Email Address</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded px-3 py-2">
        @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block font-semibold text-gray-700">Shipping Address</label>
        <textarea name="address" class="w-full border border-gray-300 rounded px-3 py-2" rows="4">{{ old('address') }}</textarea>
        @error('address')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Supplier
        </button>
    </div>
</form>
</div>
@endsection
