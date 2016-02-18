<?php

namespace App\Api\brokergeniusApp\Download;

use Illuminate\Support\Facades\DB;

class DownloadHandler
{

    /**
     * Get Download Date By UserID
     * @param $user_id
     * @return bool|int
     */
    public function get_download_date($user_id) {

        $download_data = DB::table('userdetails')
            ->select('download_date')
            ->where('user_id', '=', $user_id)
            ->get();
        if($download_data) {
            return $download_data[0]->download_date;
        } else {
            return false;
        }
    }

    /**
     * Get Latest Update Date
     * @return bool|int
     */
    public function get_latest_update_date() {

        $update_data = DB::table('Updates')
            ->select('update_date')
            ->get();
        if($update_data) {
            return $update_data[0]->update_date;
        } else {
            return false;
        }
    }

    /**
     * Update Download Date By UserID
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function update_download_date($user_id, $date) {

        $data = array("download_date" => $date);
        $download_data = DB::table('userdetails')
            ->where('user_id', '=', $user_id)
            ->update($data);
        if($download_data) {
            return true;
        } else {
            return false;
        }
    }
}