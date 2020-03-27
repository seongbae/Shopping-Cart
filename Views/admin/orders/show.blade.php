@extends('canvas::admin.layouts.app')
@section('content')
<div class="invoice p-3 mb-3">
  <!-- title row -->
  <div class="row">
    <div class="col-12">
      <h4>
      <i class="fas fa-globe"></i> {{option('business_name')}}
      </h4>
    </div>
    <!-- /.col -->
  </div>
  <!-- info row -->
  <div class="row invoice-info">
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
      Order details:<br>
      <b>Order Date:</b> {{$order->created_at}}<br>
      <b>Order Number:</b> {{$order->order_number}}<br>
      <b>CC Name:</b> {{$order->cc_name}}<br>
      <b>CC Last 4:</b> {{$order->cc_last4}}<br>
    </div>
    <div class="col-sm-4 invoice-col">
      Shipping to:
      <address>
        <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
        {{$order->street}}<br>
        @if ($order->street2) {{$order->street2}}<br> @endif
        {{$order->city}}, {{$order->state}} {{$order->zip}}<br>
        Email: {{$order->email}}
      </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
      Track shipping<br>
      Label Made: {{$order->label_made}}<br>
      Shipped: {{$order->order_shipped}}<br>
      Carrier: {{$order->shipping_carrier}}<br>
      Tracking number: {{$order->shipping_code}}
      <div class="mt-2"><a href="" class="btn btn-primary btn-sm openShippingDialog" data-toggle="modal" data-target="#exampleModal" data-carrier="{{$order->shipping_carrier}}" data-tracking="{{$order->shipping_code}}" data-shipped="{{$order->shipped}}" data-labelcreated="{{$order->label_created}}">Update Shipping</a></div>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <!-- Table row -->
  <div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Qty</th>
            <th>Product</th>
            <th>Description</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          @foreach($order->items as $item)
          <tr>
            <td>{{$item->quantity}}</td>
            <td>{{$item->product ? $item->product->name : ""}}</td>
            <td>{{$item->product ? $item->product->description : ""}}</td>
            <td>${{$item->price}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <div class="row">
    <!-- accepted payments column -->
    <div class="col-6">
      <p class="lead">Additional Information:</p>
      <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
        {{$order->notes}}
      </p>
    </div>
    <!-- /.col -->
    <div class="col-6">
      <div class="table-responsive">
        <table class="table">
          <tbody><tr>
            <th style="width:50%">Subtotal:</th>
            <td>${{$order->subtotal}}</td>
          </tr>
          <tr>
            <th>Tax</th>
            <td>${{$order->tax}}</td>
          </tr>
          <tr>
            <th>Shipping:</th>
            <td>${{$order->shipping}}</td>
          </tr>
          <tr>
            <th>Total:</th>
            <td>${{$order->total}}</td>
          </tr>
        </tbody></table>
      </div>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <!-- this row will not appear when printing -->
  <div class="row no-print">
    <div class="col-12">
      <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
      
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <form action="/admin/store/orders/{{$order->id}}/shipping" method="POST" id="shippingForm" style="display:inline;">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Shipping</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
              {{ csrf_field() }}
              <div class="form-group row">
                  <label for="name" class="col-md-4">Carrier</label>
                  <input type="text" class="form-control col-md-8" id="modalCarrier" name="carrier" placeholder="UPS, Fedex, USPS">
              </div>
              <div class="form-group row">
                  <label for="email" class="col-md-4">Tracking Code</label>
                  <input type="text" class="form-control col-md-8" id="modalCode" name="code" placeholder="123-456">
              </div>
              <div class="form-group row">
                  <label for="email" class="col-md-4">Label Created:</label>
                  <input type="checkbox" class="text-left col-md-8" id="modalLabelCreated" name="label_created" value="1">
              </div>
              <div class="form-group row">
                  <label for="email" class="col-md-4">Shipped</label>
                  <input type="checkbox" class="text-left col-md-8" id="modalShipped" name="shipped" value="1">
              </div>
              <div class="form-group row">
                  <label for="email" class="col-md-4">Notify customer</label>
                  <input type="checkbox" class="text-left col-md-8" id="modalNotify" name="notify" value="1">
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="handleSubmit()">Save changes</button>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
function handleSubmit () {
    document.getElementById('shippingForm').submit();
}


  $(document).ready(function(){
     $(document).on("click", ".openShippingDialog", function () {
      var carrier = $(this).data('carrier');
          var code = $(this).data('tracking');
          var shipped = $(this).data('shipped');
          var labelcreated = $(this).data('labelcreated');

          $(".modal-body #modalCarrier").val(carrier);
          $(".modal-body #modalCode").val(code);
          $(".modal-body #modalShipped").prop("checked", shipped);
          $(".modal-body #modalLabelCreated").prop("checked", labelcreated);
      });

  });


</script>
@endpush