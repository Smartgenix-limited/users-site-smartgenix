@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row">
            <div class="col-md-12">
                <!-- support ticket start -->
                <div class="card border-0">
                    <div class="card-header text-center bg-genix text-white">
                        {{-- <a href="{{ url()->previous() }}" class="float-start fs-20 text-white">
                            <i class="bi bi-arrow-left-short"></i>
                        </a> --}}
                        <h5 class="p-0 m-0 pt-1 text-center">{{ trans('general.ticket_information') }}</h5>
                    </div>

                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-11 border p-3 rounded">

                                @livewire('show-ticket', ['support' => $support])
                            </div>
                        </div>
                    </div>
                </div>
                <!-- support ticket start -->
            </div>
        </div>

        <!-- The Modal -->
        <div id="myModal" class="popup-modal">
            <span class="close text-danger">&times;</span>
            <img class="popup-modal-content" id="img01" />
        </div>
    </div>
@endsection
@push('scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            autosize(document.querySelectorAll('#reply'));
        }, false);
    </script> --}}
    <script>
        function getIndex(id) {
            // Get the modal
            var modal = document.getElementById("myModal");

            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var img = document.getElementById("myImg" + id);

            var modalImg = document.getElementById("img01");
            modal.style.display = "block";
            modalImg.src = img.src;

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            };
        }
    </script>
@endpush
