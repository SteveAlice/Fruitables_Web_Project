@extends('layouts.core')

@section('title', 'Carts Page')
@section('navbar')
    @parent
@endsection
@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Cart</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Order Detail</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Cart Page Start -->

    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>

                    </thead>
                    <tbody>
                        {{-- First row --}}
                        @php($subtotal = 0.0)
                        @forelse ($carts ?? [] as $item)
                            @php($subtotal += $item->product->price * $item->quantity)
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('/img/' . $item->product->image) }}"
                                            class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;"
                                            alt="">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4">{{ $item->product->name }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">{{ $item->product->price }} $</p>
                                </td>
                                <td>
                                    <div class="d-flex mt-4" style="width: 100px;">

                                        <p class="text-center border-0 bg-transparent mx-3">
                                            {{ $item->quantity }}</p>


                                    </div>
            </div>
            </td>
            <td>
                <p class="mb-0 mt-4">{{ $item->product->price * $item->quantity }}$</p>
            </td>


            </tr>
        @empty
            {{ 'No products in the cart' }}
            @endforelse


            </tbody>
            </table>
        </div>

        <div class="row g-4 justify-content-end">
            <div class="col-8"></div>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">Order <span class="fw-normal">Detail</span></h1>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Subtotal:</h5>
                            <p class="mb-0">${{ $subtotal }}</p>
                        </div>


                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0 me-4">Shipping</h5>
                            <div class="">
                                <p class="mb-0">Flat rate: {{ $shipping ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                        <h5 class="mb-0 ps-4 me-4">Total</h5>
                        <p class="mb-0 pe-4">${{ $subtotal + $shipping ?? 0 }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Cart Page End -->
@endsection




@section('footer')
    @parent
@endsection
