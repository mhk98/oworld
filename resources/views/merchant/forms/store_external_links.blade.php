   <!-- External links settings content goes here -->
   <form action="{{ route('merchant.storeSetting') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="step" value="external_links">

                    <!-- Facebook URL -->
                    <div class="mb-4">
                        <label class="form-label">Facebook URL <i class="fab fa-facebook"></i></label>
                        <input type="text" name="facebook" class="form-control" value="{{ $store->facebook }}" required>
                        @error('facebook')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Twitter URL -->
                    <div class="mb-4">
                        <label class="form-label">Twitter URL <i class="fab fa-twitter"></i></label>
                        <input type="text" name="twitter" class="form-control" value="{{ $store->twitter }}">
                        @error('twitter')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Instagram URL -->
                    <div class="mb-4">
                        <label class="form-label">Instagram URL <i class="fab fa-instagram"></i></label>
                        <input type="text" name="instagram" class="form-control" value="{{ $store->instagram }}">
                        @error('instagram')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- LinkedIn URL -->
                    <div class="mb-4">
                        <label class="form-label">LinkedIn URL <i class="fab fa-linkedin"></i></label>
                        <input type="text" name="linkedin" class="form-control" value="{{ $store->linkedin }}">
                        @error('linkedin')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Website URL -->
                    <div class="mb-4">
                        <label class="form-label">Website URL <i class="fas fa-globe"></i></label>
                        <input type="text" name="website" class="form-control" value="{{ $store->website }}">
                        @error('website')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!--- Google Map Url ---->
                    <div class="mb-4">
                        <label class="form-label">Google Map URL <i class="fas fa-globe"></i></label>
                        <input type="text" name="map_url" class="form-control" value="{{ $store->map_url }}">
                        @error('map_url')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <button class="btn submit-btn" type="submit">Save Changes</button>
                </form>