<!-- Modal -->
<div class="modal fade post-modal" id="postModal-{{ $post->id }}" tabindex="-1">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="post-item d-none d-lg-block">
                    <div class="row">
                        <div class="col-lg-8">

                            <div class="post-slider">

                                <div id="postImageCarousel{{ $post->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                                    <div class="carousel-inner">

                                    @foreach($post->images as $image)
                                        <div class="carousel-item @if($loop->first) active @endif">
                                            <div class="d-flex justify-content-center text-center">
                                                <img src="{{ asset('media/'.$image) }}" alt="Post Images">
                                            </div>
                                        </div>
                                    @endforeach

                                    </div>

                                    @if(count($post->images) > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#postImageCarousel{{ $post->id }}" data-bs-slide="prev">
                                        <i class="fas fa-chevron-left carousel-control-prev-icon"></i>
                                    </button>

                                    <button class="carousel-control-next" type="button" data-bs-target="#postImageCarousel{{ $post->id }}" data-bs-slide="next">
                                        <i class="fas fa-chevron-right carousel-control-next-icon"></i>
                                    </button>
                                    @endif

                                </div>

                            </div>

                        </div>
                        <div class="col-lg-4">
                            <div class="post-dtls d-flex align-items-start flex-column bd-highlight ps-2 ps-lg-0 h-100">

                                <div class="pb-4 d-flex justify-content-between w-100">
                                <div class="d-flex p-title">
                                       {{----  <img src="{{ asset('media/'.$store->profile_picture) }}" alt="{{ $post->store_title }}"> ----}}
                                        <a href="javascript:void(0);">{{ $post->store_title }}</a>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                                </div>

                                {{---<p>{{ $post->description }}</p>---}}
                                

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

                <div class="post-item m-device d-lg-none">
                    <div class="m-top d-flex justify-content-between">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                        <h6>Post</h6>
                        <p></p>
                    </div>
                    <div class="post-slider">
                        
                    <div id="postMobileImageCarousel{{ $post->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">

                            <div class="carousel-inner">

                                @foreach($post->images as $image)
                                        <div class="carousel-item @if($loop->first) active @endif">
                                            <div class="d-flex justify-content-center text-center">
                                                <img src="{{ asset('media/'.$image) }}" alt="Post Images">
                                            </div>
                                        </div>
                                    @endforeach

                            </div>

                            @if(count($post->images) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#postMobileImageCarousel{{ $post->id }}" data-bs-slide="prev">
                                <i class="fas fa-chevron-left carousel-control-prev-icon"></i>
                            </button>

                            <button class="carousel-control-next" type="button" data-bs-target="#postMobileImageCarousel{{ $post->id }}" data-bs-slide="next">
                                <i class="fas fa-chevron-right carousel-control-next-icon"></i>
                            </button>
                            @endif

                        </div>

                    </div>
                    <div class="post-dtls">
                        <div class="mt-auto w-100">
                            <div class="social d-flex justify-content-around m-0 mb-2">
                                <i class="far fa-heart"></i>
                                <i class="fas fa-paper-plane"></i>
                            </div>
                        </div>
                        <div class="d-flex">
                           {{---  <div class="img">
                                <img src="{{ asset('media/'.$store->profile_picture) }}" alt="{{ $post->store_title }}">
                            </div> ---}}
                            <p><a href="#">{{ $post->store_title }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>