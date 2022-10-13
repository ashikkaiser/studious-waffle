<div>
    <form action="{{ route('search') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="find-content">
                    <div class="input-group input-box">
                        <span class="input-group-text">Find</span>
                        <input type="text" class="form-control" id="postalcode" name="postal_code"
                            placeholder="Electric Showers in BH16 6FA" />
                        <input type="hidden" name="lat">
                        <input type="hidden" name="lng">
                        <input type="hidden" name="c" value="{{ request()->session()->get('search')['c'] }}">
                        <input type="hidden" name="s" value="{{ request()->session()->get('search')['s'] }}">
                        <div class="input-icon">
                            <img src="/assets/images/elc/icon.gif" alt="" style="margin-bottom: 10px;" />
                        </div>
                    </div>
                    <button>Search</button>
                </div>
            </div>
        </div>
    </form>
</div>

@section('js.search')
    <script>
        function initMap() {
            const input = document.getElementById("postalcode");
            input.placeholder = "{{ __('Enter your postcode') }}";
            const options = {
                componentRestrictions: {
                    country: "uk"
                },
                fields: ["address_components", "geometry", "icon", "name"],
                strictBounds: false,
                types: ["postal_code"],
            };
            const autocomplete = new google.maps.places.Autocomplete(input, options);
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                var code = place.address_components.find(function(item) {
                    return item.types.includes('postal_code');
                });
                var town = place.address_components.find(function(item) {
                    return item.types.includes('postal_town');
                });
                input.value = code.long_name;


                $('input[name="lat"]').val(place.geometry.location.lng());
                $('input[name="lng"]').val(place.geometry.location.lat());

            });
        }
    </script>

    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNLzN1W7LEWXFF8ssJPU7OZyh3e9-mUrM&libraries=places&callback=initMap">
    </script>
@endsection
