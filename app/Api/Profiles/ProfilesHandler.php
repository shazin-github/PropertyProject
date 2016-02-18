<?php

namespace App\Api\Profiles;

use Illuminate\Support\Facades\DB;

class ProfilesHandler {

    /**
     * Get Profiles By UserID & VenueID
     * @param $user_id
     * @param $venue_id
     * @return bool
     */
    function get_profiles($user_id, $venue_id) {

        $result = DB::table('criteria_profile')
            ->leftjoin('profile_type', 'profile_type.profile_type_id', '=', 'criteria_profile.profile_type_id')
            ->where('user_id', '=', $user_id)
            ->where('venue_id', '=', $venue_id)
            ->orderBy('profile_name', 'asc')
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Create New Profiles
     * @param $user_id
     * @param $name
     * @param $venue_id
     * @param $profile_type_id
     * @param $criteria_object
     * @return bool
     */
    function create_profile($user_id, $profile_name, $venue_id, $profile_type_id, $criteria_object) {

        $profileID = DB::table('criteria_profile')->insertGetId([
            'user_id' => $user_id,
            'venue_id' => $venue_id,
            'profile_type_id' => $profile_type_id,
            'criteria_object' => json_encode($criteria_object),
            'profile_name' => $profile_name,
        ]);

        return true;
    }

    /**
     * Update ProfileTypeID By ProfileID
     * @param $profile_id
     * @param $profile_type_id
     * @return bool
     */
    function update_profile_type($profile_id, $profile_type_id) {

        $result = DB::table('criteria_profile')
            ->where('profile_id', '=', $profile_id)
            ->get();
        if($result) {
            $data = array(
                'profile_type_id' => $profile_type_id
            );
            DB::table('criteria_profile')
                ->where('profile_id', $profile_id)
                ->update($data);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update Profile Criteria By ProfileID & UserID
     * @param $user_id
     * @param $name
     * @param $profile_type_id
     * @param $criteria_object
     * @param $profile_id
     * @return bool
     */
    function update_profile_criteria($user_id, $profile_name, $profile_type_id, $criteria_object, $profile_id) {

        $result = DB::table('criteria_profile')
            ->where('profile_id', '=', $profile_id)
            ->where('user_id', $user_id)
            ->get();
        if($result) {
            $data = array(
                'profile_name' => $profile_name,
                'criteria_object' => json_encode($criteria_object),
                'profile_type_id' => $profile_type_id
            );
            DB::table('criteria_profile')
                ->where('profile_id', $profile_id)
                ->where('user_id', $user_id)
                ->update($data);
            return true;
        } else {
            return false;
        }
    }


    /**
     * Delete Profile By ProfileID & UserID
     * @param $profile_id
     * @param $user_id
     * @return bool
     */
    function delete_profile($profile_id, $user_id) {

        $result = DB::table('criteria_profile')
            ->where('profile_id', '=', $profile_id)
            ->where('user_id', $user_id)
            ->get();
        if($result) {
            DB::table('criteria_profile')
                ->where('profile_id', '=', $profile_id)
                ->where('user_id', $user_id)
                ->delete();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get Profile Types
     * @return mixed
     */
    function get_profile_types() {

        $result = DB::table('profile_type')
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get Profile Criteria By ProfileID
     * @param $profile_id
     * @return mixed
     */
    function get_profile_criteria($profile_id) {

        $result = DB::table('criteria_profile')
            ->select('criteria_object', 'profile_name', 'venue_id', 'profile_type_id')
            ->where('profile_id', '=', $profile_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get Profile By ProfileName & UserID
     * @param $profile_name
     * @param $user_id
     * @return mixed
     */
    function get_profile_by_name($profile_name, $user_id) {

        $result = DB::table('criteria_profile')
            ->where('profile_name', '=', $profile_name)
            ->where('user_id', '=', $user_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }
}