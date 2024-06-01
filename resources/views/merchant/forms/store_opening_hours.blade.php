@if(in_array('physical', $store->store_type))
    <!-- Opening hours settings content goes here -->
    <form action="{{ route('merchant.storeSetting') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="step" value="opening_hours">
        <div class="opening-hours">

            <div class="form-separate mb-4">
                <p class="fw-bold">Opening Hours</p>
            </div>

            @php
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            @endphp

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-nowrap">Day</th>
                            <th class="text-nowrap">Opening</th>
                            <th class="text-nowrap">Closing</th>
                            <th class="text-nowrap">Open 24 Hours</th>
                            <th class="text-nowrap">Closed</th>
                        </tr>
                    </thead>

                    @foreach ($days as $day)
                        @php
                            $openingHour = $store->openingHours()->where('day', $day)->first();
                        @endphp
                        <tr>
                            <th class="text-nowrap">{{ $day }}</th>
                            <td class="text-nowrap">
                                <select class="form-select" name="{{ strtolower($day) }}_opening">
                                    @for ($i = 0; $i < 24; $i++)
                                        @php
                                            $hour = sprintf('%02d:00:00', $i);
                                        @endphp
                                        <option value="{{ $hour }}" {{ $openingHour && $openingHour->opening == $hour ? 'selected' : '' }}>
                                            {{ date('h:i A', strtotime($hour)) }}
                                        </option>
                                    @endfor
                                </select>
                            </td>
                            <td class="text-nowrap">
                                <select class="form-select" name="{{ strtolower($day) }}_closing">
                                    @for ($i = 0; $i < 24; $i++)
                                        @php
                                            $hour = sprintf('%02d:00:00', $i);
                                        @endphp
                                        <option value="{{ $hour }}" {{ $openingHour && $openingHour->closing == $hour ? 'selected' : '' }}>
                                            {{ date('h:i A', strtotime($hour)) }}
                                        </option>
                                    @endfor
                                </select>
                            </td>
                            <td class="text-nowrap">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="{{ strtolower($day) }}TwentyFourHours" name="{{ strtolower($day) }}_24h" {{ $openingHour && $openingHour->open_24h ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ strtolower($day) }}TwentyFourHours">Open 24 Hours</label>
                                </div>
                            </td>
                            <td class="text-nowrap">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="{{ strtolower($day) }}Closed" name="{{ strtolower($day) }}_closed" {{ $openingHour && $openingHour->closed ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ strtolower($day) }}Closed">Closed</label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <button class="btn submit-btn" type="submit">Save Changes</button>
    </form>
@else
    <p class="alert alert-info">Opening hours settings are only applicable for physical stores.</p>
@endif