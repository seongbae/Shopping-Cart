@extends(themePath('layouts.app'), ['banner'=>'none'])

@section('content')
<section class="bg-light page-section" id="portfolio">
    <div class="container">
      @if(flash()->message)
          <div class="alert {{ flash()->class }}">
              {{ flash()->message }}
          </div>
      @endif

      @if (!option('checkout_enabled'))
        Checkout is currently disabled.
      @elseif (count($cartItems) == 0)
        Cart empty
      @else
      <form class="needs-validation" novalidate="" id="paymentform" method="POST" action="order">
        <div class="row">
          <div class="col-lg-8 order-md-1">
            <h4 class="mb-3">Shipping address</h4>
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="firstName">First name</label>
                  <input type="text" class="form-control" id="firstName" name="first_name" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    Valid first name is required.
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="lastName">Last name</label>
                  <input type="text" class="form-control" id="lastName" name="last_name" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    Valid last name is required.
                  </div>
                </div>
              </div>
              <div class="row">
               <div class="col-md-6 mb-3">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
                  <div class="invalid-feedback">
                    Please enter a valid email address.
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="phone">Phone</label>
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="703-855-8555" required>
                  <div class="invalid-feedback">
                    Please enter a valid phone number.
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="street" placeholder="1234 Main St" required="">
                <div class="invalid-feedback">
                  Please enter your shipping address.
                </div>
              </div>
              <div class="mb-3">
                <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                <input type="text" class="form-control" id="address2" name="street2" placeholder="Apartment or suite">
              </div>
              <div class="row">
              <div class="col-md-5 mb-3">
                <label for="country">City</label>
                <input type="text" class="form-control" id="city" name="city" required="">
                <div class="invalid-feedback">
                  Please enter a city.
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="state">State</label>
                <select class="custom-select d-block w-100" id="state" name="state" required="">
                  <option value="">Choose...</option>
                  <option value="AL">Alabama</option>
                  <option value="AK">Alaska</option>
                  <option value="AZ">Arizona</option>
                  <option value="AR">Arkansas</option>
                  <option value="CA">California</option>
                  <option value="CO">Colorado</option>
                  <option value="CT">Connecticut</option>
                  <option value="DE">Delaware</option>
                  <option value="DC">District Of Columbia</option>
                  <option value="FL">Florida</option>
                  <option value="GA">Georgia</option>
                  <option value="HI">Hawaii</option>
                  <option value="ID">Idaho</option>
                  <option value="IL">Illinois</option>
                  <option value="IN">Indiana</option>
                  <option value="IA">Iowa</option>
                  <option value="KS">Kansas</option>
                  <option value="KY">Kentucky</option>
                  <option value="LA">Louisiana</option>
                  <option value="ME">Maine</option>
                  <option value="MD">Maryland</option>
                  <option value="MA">Massachusetts</option>
                  <option value="MI">Michigan</option>
                  <option value="MN">Minnesota</option>
                  <option value="MS">Mississippi</option>
                  <option value="MO">Missouri</option>
                  <option value="MT">Montana</option>
                  <option value="NE">Nebraska</option>
                  <option value="NV">Nevada</option>
                  <option value="NH">New Hampshire</option>
                  <option value="NJ">New Jersey</option>
                  <option value="NM">New Mexico</option>
                  <option value="NY">New York</option>
                  <option value="NC">North Carolina</option>
                  <option value="ND">North Dakota</option>
                  <option value="OH">Ohio</option>
                  <option value="OK">Oklahoma</option>
                  <option value="OR">Oregon</option>
                  <option value="PA">Pennsylvania</option>
                  <option value="RI">Rhode Island</option>
                  <option value="SC">South Carolina</option>
                  <option value="SD">South Dakota</option>
                  <option value="TN">Tennessee</option>
                  <option value="TX">Texas</option>
                  <option value="UT">Utah</option>
                  <option value="VT">Vermont</option>
                  <option value="VA">Virginia</option>
                  <option value="WA">Washington</option>
                  <option value="WV">West Virginia</option>
                  <option value="WI">Wisconsin</option>
                  <option value="WY">Wyoming</option>
                </select>

                <div class="invalid-feedback">
                  Please provide a valid state.
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" id="zip" name="zip" placeholder="" required="">
                <div class="invalid-feedback">
                  Zip code required.
                </div>
              </div>
            </div>
            <hr class="mb-4">
            <h4 class="mb-3">Payment</h4>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="firstName">Name on Card</label>
                  <input type="text" class="form-control" id="card-holder-name" name="card_name" placeholder="" value="" required="">
                  <div class="invalid-feedback">
                    Valid name is required.
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="firstName">Credit card number</label>
                    <div id="card-element" class="form-control">
                    <!-- A Stripe Element will be inserted here. -->           
                    </div>
                </div>
              </div>
              <hr class="mb-4">
              <button class="btn btn-primary btn-lg" type="submit" id="card-button">Purchase</button>
            
          </div>
          <div class="col-lg-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
              <span >Your cart</span> <small><a href="/cart/clear">Clear</a></small>
              <span class="badge badge-secondary badge-pill"></span>
            </h4>
            <ul class="list-group mb-3" id="cart">
              @foreach($cartItems as $item)
              <li class="list-group-item d-flex justify-content-between">
                <div style="width:200px;">
                  <div class="my-0">{{$item->item->name}}</div>
                  <small class="text-muted">${{$item->item->price}}</small>
                </div>
                <div style="width:70px;">
                  <input type="number" id="quantity" name="quantity[]" min="1" value="{{$item->quantity}}" class="form-control col-xs-2">
                  <input type="hidden" id="product" name="product[]" value="{{$item->item->id}}">
                  <input type="hidden" id="price" name="price[]" value="{{$item->item->price}}">
                  <input type="hidden" id="subtotal" name="subtotal[]" value="{{$item->subtotal}}" class="subtotal">
                </div>
                <div style="width:80px;" class="text-right">
                  <span class="text-muted">$<div id="total-{{$item->item->id}}" class="d-inline">{{$item->subtotal}}</div>
                  <br><a href="cart/remove/{{$item->item->id}}" class="float-right"><i class="fas fa-minus-circle text-muted"></i></a></span>
                </div>
              </li>
              @endforeach
              @if (option('tax_rate'))
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <div class="my-0">Tax (<div id="tax_rate" class="d-inline">0</div>%)</div>
                  <small class="text-muted"></small>
                </div>
                <span class="text-muted">$<div id="tax_amount_div" class="float-right">0</div></span>
              </li>
              @endif
              @if (option('shipping_amount') != null)
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <div class="my-0">Shipping & Handling</div>
                  <small class="text-muted"></small>
                </div>
                <span class="text-muted">{{option('shipping_amount') == 0 ? "Free" : "$".option('shipping_amount')}}</span>
              </li>
              @endif
              <!-- <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <div class="my-0">Additional donation</div>
                  <div class="mt-2">
                  <input type="range" id="donation_slider" name="donation" min="0" step="5" max="500" role="input-range" value="{{$donation}}">
                </div>
                </div>
                <span class="text-muted">$<div id="donation" class="float-right">{{$donation}}</div></span>
              </li> -->
              <li class="list-group-item d-flex justify-content-between">
                <span>Total (USD)</span>
                <strong>$<div id="total" class="float-right"></div></strong>
              </li>
            </ul>
          </div>
          <input type="hidden" name="subtotal" value="{{$subtotal}}" id="subtotal_amount">
          <input type="hidden" name="tax" value="{{$tax}}" id="tax_amount">
          <input type="hidden" name="shipping" value="{{$shipping}}" id="shipping_amount">
          <input type="hidden" name="total" value="{{$total}}" id="total_amount">
        </div>
      </form>
      @endif
    </div>
  </section>
@stop

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>

    var stripe = Stripe('{{option("stripe_public_key")}}');
    var elements = stripe.elements();
    var cardElement = elements.create('card');

    cardElement.mount('#card-element');

    // Add an instance of the card UI component into the `card-element` <div>
    var cardHolderName = document.getElementById('card-holder-name');
    var cardButton = document.getElementById('card-button');

    cardButton.addEventListener('click', async (e) => {

      if (!validateFields())
        return;

      var { paymentMethod, error } = await stripe.createPaymentMethod(
        'card', cardElement, {
            billing_details: { name: cardHolderName.value }
        }
    );

    if (error) {
        console.log('error');
        } else {
                var payment_id = paymentMethod.id;
                createPayment(payment_id);
        }   
    });

    var form = document.getElementById('paymentform');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
    });

    function validateFields() {

      var formValid = true;

      if (!$("#paymentform")[0].checkValidity()) {
        $("#paymentform")[0].reportValidity();
        formValid = false;
      }

      return formValid;
    }

    // Submit the form with the token ID.
    function createPayment(payment_id) {
    // Insert the token ID into the form so it gets submitted to the server
      var form = document.getElementById('paymentform');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'payment_id');
      hiddenInput.setAttribute('value',payment_id);
      form.appendChild(hiddenInput);
      // Submit the form

      form.submit();

    }
</script>
<script>
  jQuery(function($) {

    var taxRate = @json($taxRate);
     
    // // Set initial values
    calculateSubtotal();
    calculateTotal();

    // initial layout update
    $('.rangeslider__fill').css('background','#DD1804');

    // update when item quantity is changed
    $(document).on("keyup mouseup","#quantity:input", updateItem);

    // update when donation slider is changed
    $('input[type="range"]').rangeslider({
      polyfill : false,
      onInit : function() {
          //this.output = $( '<div class="range-output" />' ).insertAfter( this.$range ).html( this.$element.val() );
      },
      onSlide : function( position, value ) {
          $("#donation").text(value);

          calculateTotal();
      }
    });

    // Update tax rate, amount, and total when state is changed
    $("#state").change(function () {
        var state = this.value;
        var subtotal = 0;
        
        calculateSubtotal();

        updateTax();

        calculateTotal();
    });

    function updateItem() {
      var id = $(this).parent().find("#product").val();
      var price = $(this).parent().find("#price").val();
      var quantity = $(this).parent().find("#quantity").val();
      var itemTotal = price * quantity;
      var subtotal = 0;

      // console.log("id: "+id);
      // console.log("price: " + price);
      // console.log("quantity: " + quantity);
      //var itemTotalElem = $(this).parent().find("#item-"+id);
      
      //console.log(id);
      $('#total-'+id).text(itemTotal.toFixed(2));
      $(this).parent().find("#subtotal").val(itemTotal.toFixed(2));

      // $('.subtotal', $('#cart')).each(function () {
      //     subtotal = +subtotal + +$(this).val(); //log every element found to console output
      // });

      //console.log("subtotal: " + subtotal);
      calculateSubtotal();
      updateTax();
      calculateTotal();
    }

    function getTax(amount, state) {
      var taxAmount = 0;
      var itemTotal = 0;

      if (state in taxRate)
        taxAmount = amount * taxRate[state] / 100;

      return taxAmount.toFixed(2);
    }

    function updateTax() {
      var subtotal = $('#subtotal_amount').val();
      var state = $("#state").children("option:selected").val();
      var taxAmount = getTax(subtotal, state);

      $("#tax_rate").text(taxRate[state]);
      $("#tax_amount_div").text(taxAmount);
      $("#tax_amount").val(taxAmount);
    }

    function calculateSubtotal() {
      var subtotal = 0;
      
      $('.subtotal', $('#cart')).each(function () {
          subtotal = +subtotal + +$(this).val(); //log every element found to console output
      });

      $('#subtotal_amount').val(subtotal.toFixed(2));
    }

    function calculateTotal() {
      var subtotal = 0;
      var shipping = {{$shipping}};
      // var donation = parseInt($("#donation").text());
      var state = $("#state").children("option:selected").val();
      var total = 0;

      $('.subtotal', $('#cart')).each(function () {
          subtotal = +subtotal + +$(this).val(); //log every element found to console output
      });

      subtotal = +subtotal + +getTax(subtotal, state);

      total = +subtotal + +shipping;

      $('#total').text(total.toFixed(2));
      $('#total_amount').val(total.toFixed(2));
    }
  });
</script>
@endpush