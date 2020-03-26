@extends('admin.layouts.app')

@section('content')
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Update Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                {{ Form::model( $product, ['route' => ['admin.products.update', $product->id], 'method' => 'put', 'role' => 'form', 'enctype'=>'multipart/form-data'] ) }}
                @csrf
                @include('cart::admin.products.form')
                <!-- /.card-footer -->
                {{ Form::close() }}
            </div>
@endsection
