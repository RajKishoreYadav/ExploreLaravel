@extends('layouts.app')

@section('main')
<div class="container">
    <div class="text-right">
        <a href="products/create" class="btn btn-dark mt-2">New Product</a>
    </div>
    <table class="table table-hover mt-2">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Image</th>
                <th>Upload Images</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{$loop->index+1}}</td>
                <td>
                    <a href="products/{{ $product->id}}/show" class="text-dark">{{ $product->name}}</a>
                </td>
                <td>
                    <!-- <img src="products/{{$product->image}}" class="rounded-circle" width="50" height="50" /> -->
                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('products/' . $product->image) }}" class="rounded-circle" width="50" height="50" style="width: 50px; height: 50px; border-radius: 50%;">
                </td>
                <td>
                    <a href="{{url('products/'.$product->id.'/upload')}}" class="btn btn-info">Add/View Images</a>
                </td>
                <td>
                    <a href="products/{{$product->id}}/edit" class="btn btn-dark btn-sm">Edit</a>

                    <form method="POST" class="d-inline" action="products/{{$product->id}}/delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{$products->links()}}
    </div>

</div>
@endsection