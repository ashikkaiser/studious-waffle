@extends('frontend.layouts.app')

@section('css')
    <link rel="stylesheet" href="/assets/css/step1.css">
    <link rel="stylesheet" href="/assets/css/step5.css" />

    <!-- Custom Css -->
    <style>
        .business-details-area {
            position: relative;
        }

        .business-details-area::after {
            position: absolute;
            content: "";
            left: 0;
            bottom: 0;
            width: 83.32%;
            height: 4px;
            background-color: #d10a38;
        }
    </style>
@endsection
@section('content')
    <div class="business-details-area py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="business-content step-head-part">
                        <a href="{{ route('tasker.register.step4') }}"><i class="fa-solid fa-angle-left"></i> Back</a>
                        <h3 class="text-center">Payment summary</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- business details section end -->

    <!-- membership section start  -->
    <div class="membership-area pt-5 pb-2">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="membership-content text-center">
                        <p>12 months membership</p>
                        <h3> {{ $package->price === 0 ? 'Free' : '£' . $package->price }}<span>/month +VAT</span></h3>

                        <span>
                            Switch membership tier as your business needs change, anytime in
                            your contract
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- membership section end  -->

    <!-- Breakdown section start  -->
    <div class="breakdown-area pt-3 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h4 class="steap5-common-heading">Breakdown</h4>
                    <div class="member-select-item">
                        <p> Membership tier:<span>{{ $package->name }}</span></p>
                        <p> Category:<span>{{ $category->name }}</span></p>
                        <p> Postcode:<span>{{ $session->step3['business_postal_code'] }}</span></p>
                    </div>
                    <div class="member-total-ammount">
                        <ul>
                            <li>
                                <p>Subtotal monthly membership</p>
                                <p> {{ $package->price === 0 ? 'Free' : '£' . $package->price }}</p>
                            </li>
                            <li>
                                <p>VAT 20%</p>
                                <p> {{ $package->price === 0 ? 'Free' : '£' . $package->price * 0.2 }}</p>
                            </li>
                            <li>
                                <p>Total monthly membership</p>
                                <p> {{ $package->price === 0 ? 'Free' : '£' . $package->price * 1.2 }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breakdown section end -->

    <!-- form section area start  -->
    <div class="form-section-area py-4">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 offset-md-3 stripeFrom">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Enter your card details
                            </div>
                        </div>
                        <form action="" id="stripePayment" method="POST">
                            @csrf
                            <input type="hidden" name="stripeToken">
                            <input type="hidden" name="amount" value="{{ $package->price }}">
                            <div class="card-body">
                                <div id="card-element"></div>
                            </div>
                            <button type="submit" class="sub-btn" style="border: 0px">Pay</button>

                        </form>


                    </div>
                </div>
                <div class="col-sm-12 col-md-5 offset-md-3 loginform">
                    <h4 class="steap5-common-heading">Create Your Account</h4>


                    <form action="{{ route('tasker.register.store') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" required name="email" value="{{ $session->step1['business_email'] }}"
                                class="form-control" placeholder="email" readonly />
                            <label for="">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" required name="password" class="form-control" placeholder="password" />
                            <label for="">Password</label>
                        </div>



                        <button type="submit" style="border: 0px" class="sub-btn">Continue</button>


                        <div class="notice my-3">
                            <p>
                                All fields are mandatory. We will never misuse your data or
                                spam you.
                            </p>
                            <a href="#">Read our Privacy Notice</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- form section area end -->
@endsection

@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var price = {{ $package->price }};
        if (price === 0) {
            $('.stripeFrom').hide();
            $('.loginform').show();
        } else {
            $('.stripeFrom').show();
            $('.loginform').hide();
        }

        var stripe = Stripe(
            "{{ env('STRIPE_KEY') }}"
        );
        var elements = stripe.elements();
        var cardElement = elements.create('card', {
            style: {
                base: {
                    // "fontFamily": "Montserrat",
                    "color": "#32325D",
                    "border": "2px solid #ccc",
                    "fontWeight": 400,
                    "fontSize": "18px",
                    "fontSmoothing": "antialiased",
                    "::placeholder": {
                        "color": "#00d3cb"
                    },
                    ":-webkit-autofill": {
                        "color": "#e39f48"
                    }
                },
                invalid: {
                    iconColor: '#FFC7EE',
                    color: '#FFC7EE',
                },
            },
        });
        var card = elements.getElement('card');
        card.mount('#card-element');

        function setOutcome(result) {


            if (result.token) {
                $('.overlayLoader').show()

                $('input[name="stripeToken"]').attr('value', result.token.id);
                $.post("{{ route('payment.stripePost') }}", {
                    _token: "{{ csrf_token() }}",
                    ...result,
                    amount: $('input[name="amount"]').val(),

                }).then(res => {
                    // const customer = await stripe.customers.create({
                    //     email: "{{ $session->step1['business_email'] }}",
                    //     name: "{{ $session->step1['business_name'] }}",
                    // });
                    if (res.success) {
                        $('.stripeFrom').hide();
                        $('.loginform').show();
                    }


                    // if (res.success) {
                    //     Swal.fire({
                    //         icon: 'success',
                    //         title: 'success',
                    //         text: res.message,
                    //         allowOutsideClick: false,
                    //         allowEscapeKey: false,
                    //         confirmButtonColor: "#DD6B55",
                    //         confirmButtonText: "Redirect Soon",
                    //         closeOnConfirm: false
                    //     })
                    //     setTimeout(function() {
                    //         window.location.href = res.redirect;
                    //     }, 2000);
                    //     $('.overlayLoader').hide()
                    // } else {
                    //     Swal.fire({
                    //         icon: 'error',
                    //         title: 'Oops...',
                    //         text: res.message,
                    //     })
                    //     $('.overlayLoader').hide()
                    // }
                })

            } else if (result.error) {

            }
        }
    </script>

    <script>
        $('#stripePayment').on('submit', function(e) {
            e.preventDefault();

            var options = {
                name: "{{ $session->step4['first_name'] . ' ' . $session->step4['last_name'] }}",
                email: "{{ $session->step1['business_email'] }} ",
                address_country: "UK",
                address_zip: "{{ $session->step3['business_postal_code'] }}",
                currency: "gbp",
            };
            stripe.createToken(card, options).then(setOutcome);

        })
    </script>
@endsection
