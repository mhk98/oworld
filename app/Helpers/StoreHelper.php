<?php 
namespace App\Helpers;

class StoreHelper
{
    /**
     * Calculate the opening hours status and hours until the next opening for a given store.
     *
     * @param  \App\Models\Store  $store
     * @return array
     */
    public static function openingHours($store)
    {
        $currentDay = ucfirst(strtolower(date('l')));
        $openingHoursData = $store->openingHours->keyBy('day');
        $openingHoursStatus = 'not_found';
        $hoursUntilNextOpening = '';

        if ($openingHoursData->isEmpty()) {
            $openingHoursStatus = 'not_found';
        } elseif ($openingHoursData->has($currentDay)) {
            $currentDayData = $openingHoursData[$currentDay];
            $currentTime = strtotime(date('H:i'));
            $openingTime = strtotime($currentDayData->opening);
            $closingTime = strtotime($currentDayData->closing);

            if (!$currentDayData->closed) {
                if ($currentDayData->open_24h || ($currentTime >= $openingTime && $currentTime < $closingTime)) {
                    $openingHoursStatus = 'open_now';
                } else {
                    $openingHoursStatus = 'closed_now';
                }
            } else {
                $openingHoursStatus = 'closed_now';
            }

            if ($openingHoursStatus == 'closed_now') {
                $nextDay = date('l', strtotime('+1 day'));
                if ($openingHoursData->has($nextDay)) {
                    $nextDayData = $openingHoursData[$nextDay];
                    if ($nextDayData->closed) {
                        $hoursUntilNextOpening = $nextDay . " Off";
                    } else {
                        $nextOpeningTime = strtotime($nextDayData->opening);
                        $timeDiff = $nextOpeningTime - $currentTime;
                        $hoursUntilNextOpening = floor($timeDiff / 3600);
                    }
                }
            }
        }

        return [
            'currentDay' => $currentDay,
            'openingHoursData' => $openingHoursData,
            'openingHoursStatus' => $openingHoursStatus,
            'hoursUntilNextOpening' => $hoursUntilNextOpening,
        ];
    }
}