@extends('layouts.master')

@section('title', ' Edit Category')  

@section('content')


<div class="w-full bg-slate-500 p-3 text-white text-center ">
    <h1 class="text-2xl font-bold tracking-wide">Caregory Edit Selection</h1>
</div>

<div class="container mx-auto p-6"><form action="{{ route('category.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div>
        <label class="block font-semibold text-gray-700">Category Name</label>
        <input type="text" name="name" value="{{ $category->name }}" class="w-full border border-gray-300 rounded px-3 py-2">
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block font-semibold text-gray-700">Description</label>
        <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2" rows="4">{{ $category->description }}</textarea>
        @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Category
        </button>
    </div>
</form>

</div>
@endsection  