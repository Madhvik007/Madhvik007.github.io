<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="mb-0">List Product</h1>
                        @if(auth()->user()->usertype == 'admin')
                            <a href="{{ route('admin/products/create') }}" class="btn btn-primary">Add Product</a>
                        @endif
                    </div>
                    <hr />
                    @if(Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <table class="table table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Price</th>
                                @if(auth()->user()->usertype == 'admin')
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $product->title }}</td>
                                    <td class="align-middle">{{ $product->category }}</td>
                                    <td class="align-middle">{{ $product->price }}</td>
                                    @if(auth()->user()->usertype == 'admin')
                                        <td class="align-middle">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ route('admin/products/edit', ['id'=>$product->id]) }}" type="button" class="btn btn-secondary">Edit</a>
                                                <a href="{{ route('admin/products/delete', ['id'=>$product->id]) }}" type="button" class="btn btn-danger">Delete</a>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="{{ auth()->user()->usertype == 'admin' ? 5 : 4 }}">Product not found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
