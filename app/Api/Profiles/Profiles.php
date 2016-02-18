<?php

namespace App\Api\Profiles;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\Profiles\ProfilesHandler;
use App\Api\Criterias\CriteriasHandler;
use App\Api\Helper\PlanHelper;

class Profiles {

    protected $handle_profiles;
    protected $handle_criteria;
    protected $user_id;
    protected $broker_key;
    protected $helper;
    protected $user;
    protected $plan;
    protected $response;


    public function __construct(ProfilesHandler $handle_profiles, Users $user, Helper $helper, PlanHelper $plan, CriteriasHandler $handle_criteria)
    {
        $this->handle_profiles = $handle_profiles;
        $this->handle_criteria = $handle_criteria;
        $this->helper = $helper;
        $this->user = $user;
        $this->plan = $plan;
        $this->broker_key = $this->helper->get_header_key();
        $this->user_id = (string)$this->user->get_user_id($this->broker_key);
    }

    /**
     * Get Profiles By VenueID
     * @param $venue_id
     * @return mixed
     */
    public function get_profiles($venue_id)
    {
        $user_id = $this->user_id;
        if($user_id) {
            return $this->handle_profiles->get_profiles($user_id, $venue_id);
        } else {
            return 404;
        }
    }

    /**
     * Create New Profiles
     * @param $name
     * @param $venue_id
     * @param $profile_type_id
     * @param $criteria
     * @return bool
     */
    public function create_profile($profile_name, $venue_id, $profile_type_id, $criteria)
    {
        $user_id = $this->user_id;
        if($user_id) {
            return $this->handle_profiles->create_profile($user_id, $profile_name, $venue_id, $profile_type_id, $criteria);
        } else {
            return 404;
        }
    }

    /**
     * Update ProfileTypeID By ProfileID
     * @param $profile_id
     * @param $profile_type_id
     * @return bool
     */
    public function update_profile_type($profile_id, $profile_type_id)
    {
        $user_id = $this->user_id;
        if($user_id) {
        return $this->handle_profiles->update_profile_type($profile_id, $profile_type_id);
        } else {
            return 404;
        }
    }

    /**
     * Update Profile Criteria By ProfileID
     * @param $profile_name
     * @param $profile_type_id
     * @param $profile_id
     * @param $splits
     * @param $increment_type
     * @param $increment
     * @param $ceiling
     * @param $floor
     * @return bool|int
     */
    public function update_profile_criteria($profile_name, $profile_type_id, $profile_id, $splits, $increment_type, $increment, $ceiling, $floor)
    {
        $user_id = $this->user_id;
        if($user_id) {
            $old_profile = $this->handle_profiles->get_profile_criteria($profile_id);

            if ($old_profile) {
                $old_profile = $old_profile[0];
                $criteria = json_decode($old_profile->criteria_object);
                $venue_id = $old_profile->venue_id;

                $criteria->price_min = $floor;
                $criteria->price_change = $increment;
                $criteria->be = $splits;
                $criteria->celing = $ceiling;
                $criteria->increment_type = $increment_type;
                $criteria->increment_val = $increment;

                return $this->handle_profiles->update_profile_criteria($user_id, $profile_name, $profile_type_id, $criteria, $profile_id);
            } else {
                return 403;
            }
        } else {
            return 404;
        }
    }

    /**
     * Create Duplicate Profile By Profile ID
     * @param $profile_name
     * @param $clone_of
     * @param $splits
     * @param $increment
     * @param $ceiling
     * @param $floor
     * @return bool|int
     */
    function duplicate_profile($profile_name, $clone_of, $splits, $increment, $ceiling, $floor) {
        $user_id = $this->user_id;
        if($user_id) {
            $old_profile = $this->handle_profiles->get_profile_criteria($clone_of);
            if($old_profile) {
                $old_profile = $old_profile[0];
                $criteria = json_decode($old_profile->criteria_object);
                $venue_id = $old_profile->venue_id;
                $profile_type_id = $old_profile->profile_type_id;
                $criteria->price_min = $floor;
                $criteria->price_change = $increment;
                $criteria->be = $splits;
                $criteria->celing = $ceiling;

                return $this->handle_profiles->create_profile($user_id, $profile_name, $venue_id, $profile_type_id,
                    $criteria);
            } else {
                return 403;
            }
        } else {
            return 404;
        }
    }

    /**
     * Delete Profile By ProfileID
     * @param $profile_id
     * @return bool
     */
    public function delete_profile($profile_id)
    {
        $user_id = $this->user_id;
        if($user_id) {
        return $this->handle_profiles->delete_profile($profile_id, $user_id);
        } else {
            return 404;
        }
    }

    /**
     * Get Profile Types
     * @return mixed
     */
    public function get_profile_types()
    {
        $user_id = $this->user_id;
        if($user_id) {
        return $this->handle_profiles->get_profile_types();
        } else {
            return 404;
        }
    }

    /**
     * Get Profile Criteria By ProfileID
     * @param $profile_id
     * @return mixed
     */
    public function get_profile_criteria($profile_id)
    {
        $user_id = $this->user_id;
        if($user_id) {
        return $this->handle_profiles->get_profile_criteria($profile_id);
        } else {
            return 404;
        }
    }

    /**
     * Get Profile By ProfileName
     * @param $profile_name
     * @return mixed
     */
    public function get_profile_by_name($profile_name)
    {
        $user_id = $this->user_id;
        if($user_id) {
        return $this->handle_profiles->get_profile_by_name($profile_name, $user_id);
        } else {
            return 404;
        }
    }


    /**
     * Update Listings Criteria By ProfileID
     * @param $listings
     * @param $profile_id
     * @param $event_id
     * @return bool|int
     */
    function update_listings_criteria($listings, $profile_id, $event_id) {
        $user_id = $this->user_id;
        if($user_id) {
            $criteria = $this->handle_profiles->get_profile_criteria($profile_id);
            $criteria = $criteria[0];
            $criteria_object = json_decode($criteria->criteria_object);
            if ($this->plan->get_user_limit(count($listings), $user_id)) {
                if (count($listings)) {
                    foreach ($listings as $key => $listing_id) {
                        $data = [
                            'component_id' => 1,
                            'criteria_object' => $criteria_object,
                            'listing_id' => $listing_id,
                            'exchange_event_id' => $event_id,
                            'exchange_id' => 1
                        ];
                        if ($this->handle_criteria->check_listing_exist($listing_id)) {
                            return $this->handle_criteria->update_criteria($data);
                        } else {
                            return $this->handle_criteria->save_criteria($data);
                        }
                    }
                }
            } else {
                return 403;
            }
        } else {
            return 404;
        }
    }
}
