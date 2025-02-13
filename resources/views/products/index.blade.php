<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-4">Product List</h1>
                    <table class="table table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $product->title }}</td>
                                    <td class="align-middle">{{ $product->category }}</td>
                                    <td class="align-middle">{{ $product->price }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="4">No products available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
