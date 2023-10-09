<?php
/**
 * Interface : UploadHistoryInterface.
 *
 * This file used to initialise all upload history related activities
 *
 * @author Sumesh K V <sumeshvasu@gmail.com>
 *
 * @version 1.0
 */

namespace App\Models\Repositories\UploadHistory;

interface UploadHistoryInterface
{
    /**
     * Get list.
     */
    public function getList();

    /**
     * Store upload history.
     */
    public function store($fileName);

    /**
     * Update status.
     */
    public function updateStatus($fileName, $status);
}