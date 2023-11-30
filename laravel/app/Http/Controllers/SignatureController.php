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
  


    public function createSigning(Application $application, User $user)
    {



        $curl = curl_init();

        curl_setopt_array($curl, [
          //Read env file to set URL
          CURLOPT_URL => $this->Doc_Seal_API,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",        
          CURLOPT_POSTFIELDS => json_encode([
            //read env for docseal template to use
            "template_id" => $this->template_ID,
            "submission" => [
                [
                    "submitters" => [
                        [
                            "name" => $user->real_name,
                            "email" => $user->email,
                            "phone" => $user->phone,
                            "values" => [],
                            "application_key" => "string",
                            "fields" => [
                                ["name" => "Artist", "default_value" => $user->real_name],
                                ["name" => "Amount", "default_value" => $application->amount_funded],
                                ["name" => "art_name", "default_value" => $application->name],
                                ["name" => "Description", "default_value" => $application->description]
                            ]
                        ]
                    ]
                ]
            ]
                            ]),



          CURLOPT_HTTPHEADER => [
            $this->Auth_token,
            "content-type: application/json"
          ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
              
       if (curl_errno($curl) ==0) {
          curl_close($curl);
          $responseData = json_decode($response, true);
          //Create a new signature and set values; slug is appeneded to the Contract URL to create the signature link. 
          $newContract = new Signature();
          $newContract->contractID = $responseData[0]["submission_id"];
          $newContract->slug = $responseData[0]["slug"];
          $newContract->status = "sent";
          $newContract->sent = $responseData[0]["sent_at"];
          return $newContract;
      }

      else {
          //return the error
          $err = curl_error($curl);
          curl_close($curl);

          return [$err];



        
    }

  }

    public function SigningStatus(Signature $signature) {

      $curl = curl_init();
  
      //Call API to check status, updates status and returns summary
      curl_setopt_array($curl, [
      CURLOPT_URL => $this->Doc_Seal_API . "/" . $signature->contractID,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => [
        $this->Auth_token
      ],
      ]);
  
      $response = curl_exec($curl);
      $err = curl_error($curl);
  
       
      curl_close($curl);
  
      $responseData = json_decode($response, true);
  
  
      if ($responseData["submitters"][0]["opened_at"] == null ) {
          return "Sent";
      }
      elseif ($responseData["submitters"][0]["completed_at"] == null ) {
          $signature->status="opened";
          $signature->opened = $responseData["submitters"][0]["opened_at"];
          $signature->save();
          return "Opened";
        
        }
      else {
        $signature->status="signed";
        $signature->signed = $responseData["submitters"][0]["completed_at"];
        $signature->save();
        return "Signed";
      }
  
      }
  
  
  
      }
  

