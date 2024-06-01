<!-- Modal -->
<div class="modal fade post-modal" id="profilePictureModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">

                <div class="post-item d-none d-lg-block">
                    <div class="row">

                  
                        <div class="col-lg-8">
                        <div class="d-flex justify-content-center align-items-center text-center">
                        <img src="{{ asset('media/'.$store->profile_picture) }}" alt="Pofile Picture">
                        </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="post-dtls d-flex align-items-start flex-column bd-highlight ps-2 ps-lg-0 h-100">

                                <div class="pb-4 d-flex justify-content-between w-100">
                                <div class="d-flex p-title">
                                        <img src="{{ asset('media/'.$store->profile_picture) }}" alt="{{ $store->business_name }}">
                                        <a href="{{ route('store', $store->slug) }}">{{ $store->business_name }}</a>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                                </div>                                

                                <div class="mt-2 w-100">
                                    <div class="social d-flex justify-content-around">
                                        <i class="far fa-heart"></i>
                                        <i class="fas fa-paper-plane"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>