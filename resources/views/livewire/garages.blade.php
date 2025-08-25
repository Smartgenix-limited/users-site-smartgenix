<div class="col-12">
    <div class="d-flex align-items-center">
        <input id="search" class="form-control form-control-sm" type="text" wire:model=search placeholder="Search...">
        {{-- <span class="circle d-block cursor-pointer ml-2" title="Search"><i class="bi bi-search fs-18"></i></span> --}}
    </div>

    {{-- search results --}}
    <div class="row mt-4">
        {{-- map --}}
        <div class="col-md-6 mb-3" wire:ignore>
            <div class="card">
                <div class="card-body">
                    <div id="map"></div>
                </div>
            </div>
        </div>
        {{-- garages list --}}
        <div class="col-md-6">
            @foreach ($garages as $garage)
                <div class="border rounded mb-2 p-3">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h6>{{ $garage->name }}</h6>
                            <h6>{{ $garage->address }}</h6>
                            <h6>{{ $garage->telephone }}</h6>
                        </div>
                        <div class="col-md-3">
                            <h4>{{ round($garage->reviews_avg_rating, 1) ?? 0 }}/5</h4>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('garages.show', $garage) }}" class="fs-30 pl-2 text-primary"><i
                                    class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- @if ($total > $results)
                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-sm btn-genix d-flex align-items-center" wire:click="loadMore">
                        <span>Load More </span>
                        <i class="bi bi-arrow-clockwise fs-16 pl-1"></i>
                    </button>
                </div>
            @endif --}}
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>
    <script type="text/javascript">
        drawMap(@json($garages))

        // function initMap() {
        //     const myLatLng = {
        //         lat: 30.9709356,
        //         lng: 72.4826474
        //     };
        //     const map = new google.maps.Map(document.getElementById("map"), {
        //         zoom: 5,
        //         center: myLatLng,
        //     });

        //     let locations = @json($garages);

        //     let infowindow = new google.maps.InfoWindow();

        //     let marker, i;

        //     for (i = 0; i < locations.length; i++) {
        //         marker = new google.maps.Marker({
        //             position: new google.maps.LatLng(locations[i].latitude, locations[i].longitude),
        //             map: map
        //         });

        //         google.maps.event.addListener(marker, 'click', (function(marker, i) {
        //             return function() {
        //                 infowindow.setContent(locations[i].name);
        //                 infowindow.open(map, marker);
        //                 // window.location.href = `garages/${locations[i].id}`;
        //             }
        //         })(marker, i));

        //     }
        // }
        // window.initMap = drawMap;
    </script>
@endpush
