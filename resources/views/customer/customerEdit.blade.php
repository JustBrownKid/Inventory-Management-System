@extends('layouts.master')

@section('title', 'Edit Customer')

@section('content')

<div class="w-full bg-slate-500 p-3 text-white text-center">
    <h1 class="text-2xl font-bold tracking-wide">Customer Edit</h1>
</div>

<div class="container mx-auto p-6">
    <form action="{{ route('customer.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-semibold text-gray-700">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $customer->name) }}" 
                   class="w-full border border-gray-300 rounded px-3 py-2">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label class="block font-semibold text-gray-700">Email Address</label>
            <input type="email" name="email" value="{{ old('email', $customer->email) }}" 
                   class="w-full border border-gray-300 rounded px-3 py-2">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label class="block font-semibold text-gray-700">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" 
                   class="w-full border border-gray-300 rounded px-3 py-2">
            @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label class="block font-semibold text-gray-700">Address</label>
            <textarea name="address" class="w-full border border-gray-300 rounded px-3 py-2" rows="4">{{ old('address', $customer->address) }}</textarea>
            @error('address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save Customer
            </button>
        </div>
    </form>
</div>

@endsection
