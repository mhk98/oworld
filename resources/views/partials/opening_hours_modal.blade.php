@if ($openingHoursStatus !== 'not_found')
<!-- Opening Hours Modal -->
<div class="modal fade open-time" id="openingHours" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title">Opening Hours</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body p-2 p-lg-3">
                <div class="d-flex">
                    <div class="t-icon">
                        <i class="far fa-clock"></i>
                    </div>
                    <div class="time-table w-100">
                        <h6>Hours</h6>
                        
                        @if($openingHoursStatus == 'open_now')
                        <span class="s-status text-success">
                            Open Now
                        </span>
                        @elseif (is_numeric($hoursUntilNextOpening))
                        <span class="s-status text-warning">
                            Opens in {{ $hoursUntilNextOpening }} hours
                        </span>
                        @else
                        <span class="s-status text-warning">
                            {{ $hoursUntilNextOpening }}
                        </span>
                        @endif

                        <div class="d-flex justify-content-between w-100">
                            @if ($openingHoursStatus != 'not_found')
                            <div class="day">
                                @foreach($openingHoursData as $dayData)
                                <p class="{{ strtolower($currentDay) === strtolower($dayData->day) ? 'active' : '' }}">{{ ucfirst($dayData->day) }}</p>
                                @endforeach
                            </div>
                            <div class="time">
                                @foreach($openingHoursData as $dayData)
                                @php
                                $openingTime = date('h:i a', strtotime($dayData->opening));
                                $closingTime = date('h:i a', strtotime($dayData->closing));
                                @endphp
                                @if ($dayData->open_24h)
                                <p>24 Hours</p>
                                @elseif ($dayData->closed)
                                <p>Closed</p>
                                @else
                                <p>{{ $openingTime }} - {{ $closingTime }}</p>
                                @endif
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif