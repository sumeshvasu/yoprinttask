<?php
use Carbon\Carbon;

/**
 * Display readable time difference
 *
 * @param string $createdAt
 * @param string $updatedAt
 *
 * @return float
 *
 * @author Sumesh K V <sumeshvasu@gmail.com>
 */
function displayReadableTimeDifference($createdAt, $updatedAt)
{
    $startTime = Carbon::parse($createdAt);
    $endTime = Carbon::parse($updatedAt);

    return round($endTime->diffInSeconds($startTime) / 60, 2);
}
