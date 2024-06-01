<div class="modal fade content-modal" id="logoModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="h-100 m-0">
                    <div class="row h-100 p-0 m-0">
                        <div class="col-md-8 p-0">
                            <div class="image-view-wrapper">
                                <div class="image-view-inner">
                                    <div class="image-item">
                                        <div class="d-flex justify-content-center text-center">
                                            <img src="{{ asset('media/'.$store->profile_picture) }}" alt="Logo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Start Content Details -->
                            <div class="content-details d-flex flex-column h-100">
                                <div class="pb-4 d-flex justify-content-between w-100">
                                    <div class="d-flex align-items-center">
                                        @if($store->profile_picture)
                                        <img src="{{ asset('media/'.$store->profile_picture) }}" alt="{{ $store->business_name }}">
                                        @endif
                                        <a href="{{ route('store', $store->slug) }}" class="store-title">{{ $store->business_name }}</a>
                                    </div>
                                    <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>

                                <div class="mt-2 w-100">
                                    <div class="d-flex justify-content-around content-action">

                                        <a href="javascript:void(0);" id="likeContent" data-id="{{ $store->id }}" data-type="logo">
                                            <i class="{{ $isLike ? 'fas' : 'far' }} fa-heart"></i>
                                            <span>{{ $likes }}</span>
                                        </a>

                                        <a href="javascript:void(0);" id="shareContent" data-url="{{ $shareUrl }}">
                                            <i class="fas fa-share"></i>
                                        </a>


                                    </div>
                                </div>

                                <!-- Start Comments -->
                                <div class="comments w-100">
                                    <h6 class="py-3">Comments</h6>
                                    <form action="javascript:void(0);" class="comment-form w-100" data-content="{{ $store->id }}" data-type="logo">
                                        <textarea class="form-control" name="comment" placeholder="Enter your comment..." required></textarea>
                                        <div class="text-end mt-2">
                                            <button type="submit" class="btn btn-default submit-comment">Post</button>
                                        </div>
                                    </form>

                                    <div class="comment-items" id="comments-list-{{ $store->id }}">
                                        @if(!empty($comments) && $comments->count() > 0)
                                        @foreach($comments as $comment)
                                        <div class="comment-item mt-2" id="comment-{{ $comment->id }}">
                                            <div class="d-flex flex-row align-items-center py-2">
                                                <div class="w-100">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span>{{ $comment->user->first_name }}</span>
                                                        <div>
                                                            <small>{{ $comment->created_at->diffForHumans() }}</small>

                                                            @if($comment->isOwner())
                                                            <button class="btn btn-sm btn-danger delete-comment" data-comment-id="{{ $comment->id }}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <p class="text-justify comment-text mb-0">{{ $comment->comment }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>

                                </div>
                                <!-- End Comments -->
                            </div>
                            <!-- End Content Details -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>