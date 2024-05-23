@extends('layouts.admin')
@section('title', 'Order Manager')

@section('master')
    @parent
@endsection



@section('content')
    <main>
        <h1 class="m-3">Order Manager</h1>
        <div class="container-fluid py-2">
            @if (session('notice'))
                <div class="alert alert-info" role="alert">
                    {{ session('notice') }}
                </div>
            @endif

            <div class="d-flex justify-content-end">
                <p>search</p>
            </div>

            <table class="table table-bordered border-info align-middle table-responsive">
                <thead class="thead-dark">
                    <tr>
                        <th>#ID</th>
                        <th>User Name</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Shipping</th>
                        <th>Status</th>
                        <th>Acction</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders ?? [] as $item)
                        <tr>
                            <th>
                                <h1><a href="{{ route('admin.orders.show', $item->id) }}" class="badge badge-secondary-lg text-success">{{ $item->id }}</a>
                                </h1>

                            </th>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->order_date }}</td>
                            <td>{{ $item->total_amount }}</td>
                            <th>${{ $item->shipping }}</th>
                            <th>
                                @switch($item->status)
                                    @case('processing')
                                        <span class="badge bg-warning text-dark">
                                            {{ $item->status }}</span>
                                    @break

                                    @case('shipping')
                                        <span class="badge bg-info text-dark">
                                            {{ $item->status }}</span>
                                    @break

                                    @case('delivered')
                                        <span class="badge bg-success">
                                            {{ $item->status }}</span>
                                    @break

                                    @default
                                @endswitch

                            </th>
                            <td class="d-flex justify-content-center mt-md-4">
                                @switch($item->status)
                                    @case('processing')
                                        <form action="{{ route('admin.orders.update', $item->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm"><i
                                                    class="fa-solid fa-truck-fast fa-xl text-primary"></i></button>
                                        </form>
                                    @break

                                    @case('shipping')
                                        <a href=""><i class="fa-solid fa-eye fa-xl text-dark"></i></a>
                                    @break

                                    @case('delivered')
                                        <a href=""><i class="fa-solid fa-eye fa-xl text-dark"></i></a>
                                    @break

                                    @default
                                @endswitch



                            </td>
                        </tr>
                        @empty
                        @endforelse


                    </tbody>
                </table>
            </div>

        </main>
    @endsection
