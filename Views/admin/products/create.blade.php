@extends('canvas::admin.layouts.app')

@section('content')
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Add Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" method="POST" action="{{route('admin.products.store')}}" enctype="multipart/form-data">
                @csrf
                @include('cart::admin.products.form')
                <!-- /.card-footer -->
              </form>
            </div>
@endsection
