@extends('layouts.admin')

@section('title','Orders Page')
    

@section('content')

<div class="py-3 py-md-5">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(session('message'))
<h1 class="alert alert-success"> {{session('message')}}</h1>
@endif
            <div class="shadow bg-white p3 mb-3">
                <h4>
                    <div class=" mt-3">
                        <div class="text-primary mt-3 mb-3">
                            <i> Orders Details</i>
                            <a href="/admin/orders" class="btn btn-primary px-2 float-end">Back</a>
                            <a href="/admin/invoice/{{$order->id}}/generate" class="btn btn-success px-2 float-end">Generate Invoice</a>
                            <a href="/admin/invoice/{{$order->id}}/view" target="_blank" class="btn btn-warning px-2 float-end">View Invoice</a>
                        </div>
                    </div>
                </h4>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Orders Details</h5>
                        <hr>
                        {{-- {{dd($orders);}} --}}
                        <h6>Order ID:  {{$order->id}}</h6>
                        <h6>Tracking ID:  {{$order->tracking_no}}</h6>
                        <h6>Ordered At:  {{$order->created_at->format('D-m-y h:i A')}}</h6>
                        <h6>Payment Mode:  {{$order->payment_mode}}</h6>
                        <div class="col-md-7">
                            <h6 class=" border p-2 text-success">
                                Order Status Message : <span class="text-uppercase">  {{$order->status_message}}</span>
                            </h6>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5>User Details</h5>
                        <hr>
                        <h6>Name:  {{$order->fullname}}</h6>
                        <h6>Email ID:  {{$order->email}}</h6>
                        <h6>Phone:  {{$order->phone}}</h6>
                        <h6>Address:  {{$order->address}}</h6>
                        <h6>Zipcode:  {{$order->zipcode}}</h6>
                    </div>

                </div>
                
                <br>

                {{-- <h5>Order Items</h5> --}}
                <hr>

                <section>
                    <div class="container">
                      <!-- row -->
                      <div class="row">
                       
                        <div class="col-lg-12 col-md-12 col-12">
                          <div class="py-6 p-md-6 p-lg-10">
                            <!-- heading -->
                            <h2 class="mb-6"> Orders Items</h2>
                
                            <div class="table-responsive-xxl border-0">
                              <!-- Table -->
                              <table class="table mb-0 text-nowrap table-centered ">
                                <!-- Table Head -->
                                <thead class="bg-light">
                                  <tr>
                                    <th>Item ID</th>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $amount = 0;
                                @endphp
                                <!-- Table body -->
                                  @foreach ($order->orderitem as $orders)
                                  <tr>
                                    <td>
                                        <div class="btn btn-sm btn-red">
                                            {{$orders->product->id}}
                                        </div>
                                    </td>
                                    <td class="align-middle border-top-0 w-0">
                                    @if ($orders->product->productimage)
                      
                                    <div class="col-3 col-md-2">
                                      <!-- img --> <img  width="100px" src="/{{$orders->product->productimage[0]->image}}" alt="Ecommerce"
                                        class="icon-shape icon-xl">
                                      </div>
                                      @else
                                      <div class="col-3 col-md-2">
                                        <!-- img --> <img src="/" alt="Ecommerce"
                                          class="icon-shape icon-xl">
                                        </div>
                                        
                                    @endif
                                </td>
                                {{-- href="{{url('/category/'.$orders->id)}}" --}}
                                <td widht="100%"  class="align-middle border-top-0">
                                    <div class="btn btn-sm btn-dark">
                                        {{$orders->product->name}}
                                    </div>
                                </td>
                                <td widht="100%" class="align-middle border-top-0">
                                    <div class="btn btn-sm btn-primary">
                                        ${{$orders->price}}
                                    </div>
                                </td>
                                    <td widht="100%" class="align-middle border-top-0">
                                        <div class="btn btn-sm btn-primary">
                                            {{$orders->quantity}}
                                        </div>
                                      </td>
                                    <td widht="100%" class="align-middle border-top-0">
                                        <div class="btn btn-sm btn-primary">
                                            ${{$orders->quantity * $orders->price }}
                                        </div>
                                    </td>
                                    @php
                                        $amount += $orders->quantity * $orders->price;
                                    @endphp
                                    
                                    {{-- <td class="align-middle border-top-0">
                                      $15.00
                                    </td> --}}
                                  </tr>
                                        @endforeach
                                  <div class="d-flex justify-content-center">

                                      <tr>
                                          <td  class="text-center"colspan="4">
                                              <div class="btn btn-primary col-md-8">
                                                  Total Amount : {{$amount}}
                                                </div>
                                            </td>
                                        </tr>
                                    </div>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
                  <div class="card border-mt-3">
                    <div class="card-body">
                        <h4>Order Process(Order Status Message)</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-5">
                                <form action="{{url('/admin/orders/'.$order->id)}}" method="post">
                                @csrf
                                @method('put')
                                <label > Update Order Details</label>
                                <div class="input-group">
        <select name="order_status" id="status" class="form-select">
            <option value="">Select Order Status</option>
            <option value="in progress" {{Request::get('status') == 'in progress' ?'selected':''}} >In Progress</option>
            <option value="completed" {{Request::get('status') == 'completed' ? 'selected':''}} >Completed</option>
            <option value="pending" {{Request::get('status') == 'pending' ?'selected':''}} >Pending</option>
            <option value="cancelled" {{Request::get('status') == 'cancelled' ?'selected':''}} >Cancelled</option>
            <option value="out-for-delivery" {{Request::get('status') == 'out-for-delivery'? 'selected':''}} >Out For Delivery</option>
        </select>
        <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                                </form>
                            </div>
                            {{-- <div class="col-md-7">
                                <br>
                                <h4 class="mt-3">Current Order Status: <span clas></span></h4>
                            </div> --}}
                            <div class="col-md-7">
                                <br>
                                <h4 class=" border p-2 text-success mt-3">
                                    Order Status Message : <span class="text-uppercase">  {{$order->status_message}}</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                  </div>
                
            </div>

        </div>
    </div>
</div>
</div>

@endsection