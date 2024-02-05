<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Application;
use App\Models\Signature;
use App\Models\Question;
use App\Models\Criteria;
use App\Models\Judged;
use App\Models\User;
use App\Models\UserData;
use App\Models\Score;
use App\Models\Round;

use App\Http\Requests\ApplicationRequest;
use App\Misc\Helper;
use Illuminate\Support\Facades\Validator;

class SignatureController extends Controller
{
    //Read env file to grab variables
    public $Auth_token;
    public $template_ID;
    public $Doc_Seal_API;

    public function __construct()
    {
        $this->Auth_token = "X-Auth-Token:" . env('DOCSEAL_TOKEN');
        $this->template_ID = env('DOCSEAL_TEMPLATE');
        $this->Doc_Seal_API = env('DOCSEAL_API_URL');
    }

    public function setStream($action, $data)
    {
        //Set URL
        $url = $this->Doc_Seal_API;

        //Set Method for action
        if($action === "Status")
        {
            //Set method to GET, and then append data passed (which should be the contract ID) to url
            $method = "GET";
            $url = $url."/$data";
        }
        elseif($action === "Create")
        {
            $method = "POST";
        }

        $contextOptions = [
            'http' => [
                'method' => $method,
                'header' =>  "Content-type: application/json\r\n". $this->Auth_token,
                'content' => json_encode($data),
            ],
            'ssl' => [
                'verify_peer' => true,
                'verify_peer_name' => true,
                'allow_self_signed' => false,
            ],
        ];

        $stream_array = [
            'url' => $url,
            'contextOptions' => stream_context_create($contextOptions),
        ];

        return $stream_array;
    }

    public function createSigning(Application $application, User $user)
    {
        //Find User ID Data
        $user_data = UserData::where ('user_id', $user->id)->first();

        // Set payload to create the signature
        $signature_payload = [
            "template_id" => $this->template_ID,
            "submission" => [
                [
                    "submitters" =>
                    [
                        [
                            "name" => $user_data->real_name,
                            "email" => $user_data->email,
                            "phone" => $user_data->phone,
                            "values" => [],
                            "application_key" => "string",
                            "fields" => [
                                ["name" => "Artist", "default_value" => $user_data->real_name],
                                ["name" => "Amount", "default_value" => $application->approved_budget],
                                ["name" => "art_name", "default_value" => $application->name],
                                ["name" => "Description", "default_value" => $application->description]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        // Get stream array
        $stream_array = $this->setStream("Create", $signature_payload);

        //Open file and get response
        $response = file_get_contents($stream_array['url'], false, $stream_array['contextOptions']);

        if($response === false)
        {
            return array("error" => error_get_last());
        }
        else
        {
            $responseData = json_decode($response, true);

            if(array_key_exists('error',$responseData))
            {
                return $responseData;
            }
            else
            {
                #Create a new signature and set values; slug is appeneded to the Contract URL to create the signature link.
                $newContract = new Signature();
                $newContract->contractID = $responseData[0]["submission_id"];
                $newContract->slug = $responseData[0]["slug"];
                $newContract->status = "sent";
                $newContract->created_at = strtotime($responseData[0]["sent_at"]);
                $newContract->user_id = $user->id;
                $newContract->application_id = $application->id;
                $newContract->save();

                return $newContract;
            }
        }
    }

    public function SigningStatus(Signature $signature)
    {
        // Set stream options, passing Status and the Contract ID
        $stream_array = $this->SetStream("Status", $signature->contractID);
        $response = file_get_contents($stream_array['url'], false, $stream_array['contextOptions']);

        // Default to error, if there is a response then the output will be overwritten
        $status = "error";

        if($response)
        {
            $responseData = json_decode($response, true);

            if(isset($responseData["submitters"][0]["sent_at"])) {
                $signature->created_at = strtotime($responseData["submitters"][0]["sent_at"]);
                $status = "sent";
            }

            if(isset($responseData["submitters"][0]["opened_at"])) {
                $signature->updated_at = strtotime($responseData["submitters"][0]["opened_at"]);
                $status = "opened";
            }

            if(isset($responseData["submitters"][0]["completed_at"])) {
                $signature->updated_at = strtotime($responseData["submitters"][0]["completed_at"]);
                $status = "signed";
            }
        }

        $signature->status = $status;
        $signature->save();

        return $status;
    }
}
