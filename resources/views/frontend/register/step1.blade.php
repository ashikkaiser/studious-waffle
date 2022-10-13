@extends('frontend.layouts.app')

@section('css')
    <link rel="stylesheet" href="/assets/css/step1.css">
    <link rel="stylesheet" href="/assets/plugin/select2/css.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js"
        integrity="sha512-odNmoc1XJy5x1TMVMdC7EMs3IVdItLPlCeL5vSUPN2llYKMJ2eByTTAIiiuqLg+GdNr9hF6z81p27DArRFKT7A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('content')
    <div class="business-details-area py-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-5 offset-md-3">
                    <div class="business-content">
                        <h3>Your business details</h3>
                        <p>
                            Thanks for your interest in Checkatrade. Please tell us a bit
                            more about your business so that we can:
                        </p>
                        <ul class="business-list">
                            <li>
                                Give you an accurate quote for the Carpet and Upholstery
                                Cleaning category
                            </li>
                            <li>Show you how many leads you could be getting</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $session = (object) session()->get('step1');
    @endphp
    <div class="form-section-area py-4">
        <div class="container">
            <div class="row">

                <div class="col-sm-12 col-md-5 offset-md-3">
                    <form action="{{ route('tasker.register.step1') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <select name="business_category" id="business_category" class="form-control">
                                <option value="" selected="selected"></option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('business_type', $session->business_category ?? '') == $item->id ? 'selected' : '' }}
                                        data-slug="{{ $item->slug }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="business_category">Your Business Category <sup>*</sup></label>
                        </div>
                        <div class="form-floating mb-3">

                            <select class="select2 business_subcategory form-control" name="business_subcategory[]"
                                id="business_subcategory" id="" multiple style="margin-left: 8px; !important">

                            </select>
                            <label for="business_subcategory">Your Sub Category <sup>*</sup></label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="business_name" name="business_name"
                                value="{{ old('business_name', $session->business_name ?? '') }}" required
                                placeholder="Your Business Name">
                            <label for="business_name">Your Business Name</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="business_phone" class="form-control" id="business_phone" required
                                value="{{ old('business_phone', $session->business_phone ?? '') }}"
                                placeholder="Your business Phone">
                            <label for="business_phone">Your Business Phone</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="business_email" required class="form-control"
                                placeholder="Your Business Email"
                                value="{{ old('business_email', $session->business_email ?? '') }}">
                            <label for="">Your Business Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="url" name="business_url" required class="form-control"
                                placeholder="Your Business Url"
                                value="{{ old('business_url', $session->business_url ?? '') }}">
                            <label for="">Your Business website</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select name="business_type" id="business_type" class="form-control">
                                <option value="" selected></option>
                                <option value="Individual"
                                    {{ old('business_type', $session->business_type ?? '') == 'Individual' ? 'selected' : '' }}>
                                    Individual</option>
                                <option value="Limited Company"
                                    {{ old('business_type', $session->business_type ?? '') == 'Limited Company' ? 'selected' : '' }}>
                                    Limited Company</option>
                                <option value="Limited"
                                    {{ old('business_type', $session->business_type ?? '') == 'Limited' ? 'selected' : '' }}>
                                    Limited</option>
                                <option value="Company"
                                    {{ old('business_type', $session->business_type ?? '') == 'Company' ? 'selected' : '' }}>
                                    Company</option>
                                <option value="MotherBoard"
                                    {{ old('business_type', $session->business_type ?? '') == 'MotherBoard' ? 'selected' : '' }}>
                                    MotherBoard</option>
                            </select>
                            <label for="business_type">Your Business Type</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="business_employee_size" id="business_employee_size" class="form-control">
                                <option value="" selected="selected"></option>
                                <option value="1"
                                    {{ old('business_employee_size', $session->business_employee_size ?? '') == '1' ? 'selected' : '' }}>
                                    1</option>
                                <option value="2-5"
                                    {{ old('business_employee_size', $session->business_employee_size ?? '') == '2-5' ? 'selected' : '' }}>
                                    2-5</option>
                                <option value="6-9">
                                    {{ old('business_employee_size', $session->business_employee_size ?? '') == '6-9' ? 'selected' : '' }}>
                                    6-9</option>
                                <option value="10+"
                                    {{ old('business_employee_size', $session->business_employee_size ?? '') == '10+' ? 'selected' : '' }}>
                                    10+</option>
                            </select>
                            <label for="business_employee_size">Your Business Employees <sup>*</sup></label>
                        </div>
                        <button class="sub-btn" style="border: 0px" type="submit">Show prices</button>

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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    <script>
        $(document).ready(function() {
            $('.select2').select2({
                // placeholder: 'Select an option',
                // allowClear: true,
                // theme: 'bootstrap5',
            });
        });
    </script>
    <script>
        $("#business_category").on('change', function() {
            var id = $(this).val();
            $.ajax({
                url: "{{ route('tasker.register.getSubCategory') }}",
                type: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('.business_subcategory').select2({
                        data: data
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#post_code').on('keyup', function() {
                var post_code = $(this).val();
                console.log(post_code)
                const isValidate = isValidUKPostcode(post_code);
                if (isValidate.error) {
                    $('#post_code').addClass('is-invalid');
                    $('#post_code').removeClass('is-valid');
                    $('.sub-btn').attr('disabled', true);
                } else {
                    $('#post_code').addClass('is-valid');
                    $('#post_code').removeClass('is-invalid');
                    $('#post_code').val(isValidate.formatedPostCode);
                    $('.sub-btn').attr('disabled', false);
                }


            });
        });
    </script>
@endsection
