<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Api\Response\Response;
use App\Api\Criterias\Criterias;
use App\Http\Middleware\filter_broker_key;
use \Validator;
class CriteriasController extends Controller
{
    protected $response;
    protected $criteria;
    protected $detail;

    public function __construct(Response $response, Criterias $criteria, filter_broker_key $broker) {
        $this->response = $response;
        $this->criteria = $criteria;
        $this->details = $broker->get();
    }

    /**
     * [saving criteria calls will be entertained here ]
     * @param  Request $request
     * @return Response
     */
    public function save(Request $request) {
        $validator = Validator::make($request->all(),[
            'listing_ids' => 'required|array',
            'exchange_event_id' => 'required',
            'criteria_object' => 'required',
            'exchange_id' => 'required',
            'local_event_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $request_data = $request->all();

        $resp = $this->criteria->save_criteria($request_data);

        if ($resp) {
            return $this->response->success($resp);
        }

        return $this->response->application_error('Something went wrong, Please try again later.');

    }

    /**
     * Update the listing criteria
     * @param  Request $request
     * @return Response
     */
    public function edit(Request $request) {
        $validator = Validator::make($request->all(),[
            'listing_ids' => 'required|array',
            'exchange_event_id' => 'required',
            'criteria_object' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $request_data = $request->all();
        //call to edit criteria or update criteria
        $resp = $this->criteria->edit_criteria($request_data);
        if ($resp) {
            return $this->response->success($resp);
        } else {
            return $this->not_found();
        }
        return $this->response->not_found();
    }

    /**
     * getting_criteria
     * @param  Request $request
     * @return Response
     */
    public function getting_criteria(Request $request) {
        $user_id = $this->details['user_id'];
        if ($request->has('exchange_event_id')) {
            $resp = $this->criteria->get_criteria_through_event_id($user_id, $request->exchange_event_id);
        } else {
            $resp = $this->criteria->get_criteria_through_listing_id($request->listing_id);
        }
        //check response
        if ($resp) {
            return $this->response->success($resp , 'Criteria get successfully');
        } else {
            return $this->response->not_found('Criteria not present');
        }
    }


    /**
     * delete_criteria
     * @param  Request $request
     * @return response
     */
    public function delete_criteria(Request $request) {
        $validator = Validator::make($request->all(),[
            'listing_ids' => 'required|array',
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $listing_ids = $request->listing_ids;
        $resp = $this->criteria->delete_criteria($listing_ids);
        if ($resp) {
            return $this->response->success('criteria deleted successfully');
        } else {
            return $this->response->not_found("Criteria Not Found");
        }
    }


    /**
     * saving_mass_operation
     * @param  Request $request
     * @return response
     */
    public function saving_mass_operation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'listing_ids' => 'required|array',
            'increment_val' => 'required',
            'increment_type' => 'required',
            'command' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $massRequest = $request->all();

        $command = $massRequest['command'];
        $listing_ids = $massRequest['listing_ids'];
        $increment = $massRequest['increment_val'];
        $increment_type = $massRequest['increment_type'];

        $floor_type = "";
        if (array_key_exists('floor_type', $massRequest)) {
            $floor_type = $massRequest['floor_type'];
        }
        if (!$listing_ids) {
            return $this->response->not_found();
        }
        $counter = 0;

        foreach ($listing_ids as $key => $listing_id) {
            $prev_criteria = $this->criteria->get_criteria_through_listing_id($listing_id);

            if ($command == "floor") {

                $updated_floor = $this->criteria->updating_criteria_floor($prev_criteria, $increment_type, $increment, $floor_type);

                if ($updated_floor) {
                    $counter = $counter + 1;
                }

            } elseif ($command == "cieling") {

                $updated_ceiling = $this->criteria->updating_criteria_ceiling($prev_criteria, $increment_type, $increment);

                if ($updated_ceiling) {
                    $counter = $counter + 1;
                }
            } else {
                $command = "increment";
                $inc_precent = $this->criteria->updating_criteria_inc($prev_criteria, $increment_type, $increment);
                if ($inc_precent) {
                    $counter = $counter + 1;
                }
            }
        }

        if ($counter > 0) {
            return $this->response->success('criteria '.$command.' price updated succefully on this much listings ' . $counter);
        }
        elseif ($counter == 0) {
            return $this->response->bad_request('criteria '.$command.' price not updated successfully');
        }
    }


    /**
     * get_moveFloor
     * @param  Request $request
     * @return response
     */
    public function getting_moveFloor(Request $request) {

        $response = $this->criteria->getting_moveFloor($this->details['user_id']);
        if ($response) {
            return $this->response->success('floor get successfully for these no of listings : ' . $response);
        } else {
            return $this->response->not_found("Listing not found");
        }
    }
}
