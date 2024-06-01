 <!-- Area settings content goes here -->
 <form action="{{ route('merchant.storeSetting') }}" id="storeSetting" method="post" enctype="multipart/form-data">
     @csrf
     <input type="hidden" name="step" value="area">

     @if(in_array('physical', $store->store_type))
     <!-- Area -->
     <div class="area-part area-accordion mb-3">
         <div class="accordion" id="areaAccordion">
             <label for="" class="form-label">Business Location <span class="text-danger">*</span></label>
             <div class="accordion-item">
                 <h2 class="accordion-header" id="headingOne">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                         Select Area
                     </button>
                 </h2>
                 <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#areaAccordion">
                     <div class="accordion-body">
                         @foreach($areas as $area)
                         <div class="form-check">
                             <input class="form-check-input" type="checkbox" name="area[]" value="{{ $area }}" id="area{{ ucfirst($area) }}Checkbox" @if(!empty($storeAreas) && in_array($area, $storeAreas)) checked @endif>
                             <label class="form-check-label" for="area{{ ucfirst($area) }}Checkbox">{{ ucwords(str_replace('_', ' ', $area)) }}</label>
                         </div>
                         @endforeach
                     </div>
                 </div>
             </div>
         </div>
         @error('area')
        <div class="invalid-feedback text-danger mt-1" role="alert">
            <strong>{{ $message }}</strong>
        </div>
        @enderror
     </div>
     @endif


     @if(in_array('physical', $store->store_type))
     <!-- Address Area -->
     <div class="address-part mb-3">
         @if($store->areas->count() > 0)
         @foreach($store->areas as $storeArea)
         @php
         $areaValue = $storeArea->area;
         $capitalizedAreaValue = ucwords(str_replace('_', ' ', $areaValue));
         @endphp
         <div class="mb-3 address-{{ $areaValue }}">
             <label class="form-label">{{ $capitalizedAreaValue }} Address <span class="text-danger">*</span></label>
             <textarea name="address[{{ $areaValue }}]" class="form-control" placeholder="Enter your address" required>{{ $storeArea->address }}</textarea>
         </div>
         @endforeach
         @endif

         @error('address')
        <div class="invalid-feedback text-danger mt-1" role="alert">
            <strong>{{ $message }}</strong>
        </div>
        @enderror

     </div>
     @endif

     @if(in_array('online', $store->store_type))
     <!-- Delivery Area -->
     <div class="delivery-area-part area-accordion mb-3">
         <div class="accordion" id="deliveryAreaAccordion">
             <label for="" class="form-label">Delivery Area <span class="text-danger">*</span></label>
             <div class="accordion-item">
                 <h2 class="accordion-header" id="headingDeliveryArea">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDeliveryArea" aria-expanded="true" aria-controls="collapseDeliveryArea">
                         Select Delivery Area
                     </button>
                 </h2>
                 <div id="collapseDeliveryArea" class="accordion-collapse collapse" aria-labelledby="headingDeliveryArea" data-bs-parent="#deliveryAreaAccordion">
                     <div class="accordion-body">
                         <div class="form-check">
                             <input class="form-check-input" type="checkbox" name="delivery_area[]" value="all" id="deliveryAreaAllCheckbox">
                             <label class="form-check-label" for="deliveryAreaAllCheckbox">All</label>
                         </div>
                         @foreach($areas as $area)
                         <div class="form-check">
                             <input class="form-check-input" type="checkbox" name="delivery_area[]" value="{{ $area }}" id="deliveryArea{{ ucfirst($area) }}Checkbox" @if(!empty($storeDeliveryAreas) && in_array($area, $storeDeliveryAreas)) checked @endif>
                             <label class="form-check-label" for="deliveryArea{{ ucfirst($area) }}Checkbox">{{ ucwords(str_replace('_', ' ', $area)) }}</label>
                         </div>
                         @endforeach
                     </div>
                 </div>
             </div>
         </div>
         @error('delivery_area')
        <div class="invalid-feedback text-danger mt-1" role="alert">
            <strong>{{ $message }}</strong>
        </div>
        @enderror
     </div>
     @endif

     <button class="btn submit-btn" type="submit">Save Changes</button>
 </form>