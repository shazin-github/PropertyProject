<?php
namespace App\Api\Criterias;
use Event;
use App\Api\Criterias\CriteriasHandler;
use App\Http\Middleware\filter_broker_key;
use App\Api\Helper\PlanHelper;
use App\Api\Helper\GroupsHelper;
use App\Events\SaveListing;
/**
 * @author: Asad
 *
 */
class Criterias
{
    protected $broker;
    protected $handler;
    protected $details;

    protected $plan_helper;
    protected $criteria_helper;


    function __construct(CriteriasHandler $handler, filter_broker_key $broker ,PlanHelper $plan_helper, GroupsHelper $criteria_helper) {

        $this->handler = $handler;
        $this->broker = $broker;

        $this->plan_helper = $plan_helper;
        $this->criteria_helper = $criteria_helper;
        $this->details = $this->broker->get();
        $this->component_id = 1;
    }

    /**
     * save_criteria
     * @param  [mixed] $data
     * @return mixed
     */
    public function save_criteria($data) {
        $user_id = $this->details['user_id'];
        $data['user_id'] = $user_id;
        $data['component_id'] = $this->component_id;
        // listing to be saved coming from request
        $listings_to_save = $data['listing_ids'];

        $plan_limit = $this->plan_helper->get_user_limit(count($listings_to_save), $user_id);

        if($plan_limit){
            $updated = 0;
            $count_saved_listings = 0;
            $counter_already_saved_or_of_group = 0;
            foreach ($listings_to_save as $listing_id) {
                $data['listing_id'] = $listing_id;
                $component_id = $this->criteria_helper->get_component_id($listing_id);
                if($component_id == 3 || $component_id == 2){
                    $counter_already_saved_or_of_group++;
                }
                elseif(!$component_id){
                    $resp = Event::fire(new SaveListing($data , $this->criteria_helper));
                    if ($resp) {
                        $count_saved_listings++ ;
                    }
                }else{
                    //send request to update the listing.
                    $this->handler->update_criteria($data);
                    $updated++ ;
                }
            }
        }
        else{
            return false;
        }
        $message = 'criteria saved succefully on ' . $count_saved_listings . ' out of ' . count($listings_to_save) . ' and updated on : ' .$updated ;

        return $message;
    }

    /**
     * edit_criteria for updating the criteria
     * @param  [mixed] $request_data []
     * @return mixed
     */
    public function edit_criteria($request_data) {

        // $this->handler->update_criteria($request_data);
        $listings_to_save = $request_data['listing_ids'];

        $count_saved_listings = 0;

        foreach ($listings_to_save as $listing_id) {
            $component_id = $this->criteria_helper->get_component_id($listing_id);
            if ($component_id == 1) {
                $request_data['component_id'] = $this->component_id;
                $request_data['listing_id'] = $listing_id;
                $this->handler->update_criteria($request_data);
                $count_saved_listings++;
            }
        }
        $message = $count_saved_listings . ' out of ' . count($listings_to_save) . ' are updated.';
        return $message;
    }

    /**
     * get_criteria_through_listing_id
     * @param  [int] $listing_id []
     * @return mixed
     */
    public function get_criteria_through_listing_id($listing_id) {
        return $this->handler->get_criteria_through_listing_id($listing_id);
    }

    /**
     * get_criteria_through_event_id
     * @param  [int] $event_id []
     * @return mixed
     */
    public function get_criteria_through_event_id($user_id,$event_id) {
        return $this->handler->get_criteria_through_event_id($user_id,$event_id);
    }

    /**
     * delete_criteria on the basis of listing id
     * @param  [mixed] $listing_ids
     * @return mixed
     */
    public function delete_criteria($listing_ids) {
        return $this->handler->delete_criteria($listing_ids);
    }

    /**
     * updating_criteria_ceiling
     * @param  [type] $prev_criteria
     * @param  [type] $increment_type
     * @param  [type] $increment
     * @return mixed
     */
    public function updating_criteria_ceiling($prev_criteria, $increment_type, $increment) {

        $new_criteria = (json_decode($prev_criteria->criteria_object, true));


        $prev_ceiling = $new_criteria['price_ceil'];

        if ($increment_type == 1) {

            $ceiling_precent = ($prev_ceiling * $increment) / 100;
            $ceiling = $prev_ceiling + $ceiling_precent;
            $ceiling = number_format((float)$ceiling, 2, '.', '');
        } else {
            $ceiling = $prev_ceiling + $increment;
            $ceiling = number_format((float)$ceiling, 2, '.', '');
        }
        if (!($ceiling < $prev_ceiling)) {

            $new_criteria['price_ceil'] = $ceiling;

            //echo "<br>".$criteria;
            $prev_criteria->criteria_object = $new_criteria;

            //dd((array)$prev_criteria);
            return $updated_criteria = $this->handler->update_criteria((array)$prev_criteria);
        }
        return false;
    }

    /**
     * updating_criteria_floor
     * @param  [mixed] $prev_criteria
     * @param  [mixed] $increment_mixed
     * @param  [mixed] $increment
     * @return mixed
     */
    public function updating_criteria_floor($prev_criteria, $increment_type, $increment,$floor_type) {

        $new_criteria = (json_decode($prev_criteria->criteria_object, true));

        $prev_floor = $new_criteria['price_floor'];
        if ($increment_type == 1) {

            $floor_precent = ($prev_floor * $increment) / 100;
            $floor = $prev_floor + $floor_precent;
            $floor = number_format((float)$floor, 2, '.', '');
        } else {
            $floor = $prev_floor + $increment;
            $floor = number_format((float)$floor, 2, '.', '');
            if ($floor_type == "manual") {
                $floor = $increment;
            }
        }

        if (!($floor <= 0))

            // floor must not be 0 or smaller than zero
        {
            $new_criteria['price_floor'] = $floor;

            $prev_criteria->criteria_object = $new_criteria;

            return $updated_criteria = $this->handler->update_criteria((array)$prev_criteria);
        }
        return false;
    }

    /**
     * updating_criteria_incpercent
     * @param  [mixed] $prev_criteria
     * @param  [mixed] $increment
     * @return mixed
     */
    public function updating_criteria_inc($prev_criteria, $increment_type, $increment) {

        $new_criteria = (json_decode($prev_criteria->criteria_object, true));

        $prev_inc = $new_criteria['price_inc'];

        if ($increment_type == 1) {

            $inc_precent = ($prev_inc * $increment) / 100;
            $inc = $prev_inc + $inc_precent;
            $inc = number_format((float)$inc, 2, '.', '');
        } else {
            $inc = $prev_inc + $increment;
            $inc = number_format((float)$inc, 2, '.', '');
        }

        $new_criteria['price_inc'] = $inc;
        $prev_criteria->criteria_object = $new_criteria;

        return $updated_criteria = $this->handler->update_criteria((array)$prev_criteria);
    }

    /**
     * getting_moveFloor description
     * @param  [mixed] $user_id [description]
     * @return mixed
     */
    public function getting_moveFloor($user_id) {

        $criterias = $this->handler->prices_criteria($user_id);

        //criterias must be an array
        $count_updated_criterias = 0;
        foreach ($criterias as $criteria) {

            $criteria = ((array)$criteria);

            if ($criteria['cp'] != '') {
                $listing_id = $criteria['listing_id'];
                $prev_criteria = (json_decode($criteria['criteria_object'], true));

                $increment = - 10;
                $prev_floor = $prev_criteria['price_floor'];
                $floor_precent = ($prev_floor * $increment) / 100;
                $floor = $prev_floor + $floor_precent;
                $floor = number_format((float)$floor, 2, '.', '');
                if (!($floor <= 0))
                    // floor must not be 0 or smaller than zero
                {
                    $prev_criteria['price_floor'] = $floor;
                    $criteria['criteria_object'] = $prev_criteria;

                    $this->handler->update_criteria($criteria);
                    $count_updated_criterias++;
                }
            }
        }
        return $count_updated_criterias;
    }
}
