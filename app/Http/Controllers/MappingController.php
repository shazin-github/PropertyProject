<?php

namespace App\Http\Controllers;

use App\Api\Events\Events;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\Mapping\Mapping;
Use App\Api\Response\Response;

class MappingController extends Controller
{
    protected $mapping;
    protected $request;
    protected $response;

    public function __construct(Mapping $mapping, Request $request, Response $response)
    {
        $this->mapping = $mapping;
        $this->request = $request;
        $this->response = $response;
    }

    public function add_mapping_issue() {
        if($this->request->has('product_name') && $this->request->has('event_id')) {
            $event_data = $this->request->all();
            $mapping = $this->mapping->add_mapping_issue($event_data);
            if($mapping === 404) {
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($mapping);
            }
        } else {
            return $this->response->forbidden('Request Paramaters are incorrect');
        }
    }

    public function update_mapping_issue() {
        if($this->request->has('event_id')) {
            $event_data = $this->request->all();
            $mapping = $this->mapping->update_mapping_issue($event_data);
            if($mapping === 404) {
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($mapping);
            }
        } else {
            return $this->response->forbidden('Request Paramaters are incorrect');
        }
    }

    public function delete_mapping_issue() {
        if($this->request->has('_id')) {
            $object_id = $this->request->input('_id');
            $mapping = $this->mapping->delete_mapping_issue($object_id);
            if($mapping === 404) {
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($mapping);
            }
        } else {
            return $this->response->forbidden('Request Paramaters are incorrect');
        }
    }

    public function get_event_data() {
        if($this->request->has('pos_name') && $this->request->has('externl_event_id')) {
            $event_data = $this->request->all();
            $mapping = $this->mapping->get_event_data($event_data);
            if($mapping === 404) {
                return $this->response->not_found('Event not found');
            } elseif($mapping === 403) {
                return $this->response->forbidden('Invalid POS');
            } elseif($mapping === 401) {
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($mapping);
            }
        } else {
            return $this->response->forbidden('Request Paramaters are incorrect');
        }
    }
}