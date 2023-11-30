<?php
use App\Http\Requests;


class signature {

public 


public $contractID;

public $slug;
public $status;
public $sent;
public $opened;
public $signed;

public function __construct() {
    $this->ContractID = null;
    $this->slug = null;
    $this->status = null;
    $this->sent = null;
    $this->opened = null;
    $this->signed = null;

}


}


class Application {
    // Properties
    public $name;
    public $description;
    public $amount_funded;
    public $status;
    public $ContractDate;
    public $Contract_ID;
    public $Contract_url;

    // Constructor
    public function __construct($name, $description, $amount_funded, $status) {
        $this->name = $name;
        $this->description = $description;
        $this->amount_funded = $amount_funded;
        $this->status = $status;
        $this->ContractDate = null;
        $this->Contract_ID = null;
        $this->Contract_url = null;
    }


}

class User {
    // Properties
    public $real_name;
    public $email;
    public $phone;
    public $id;

    // Constructor
    public function __construct($real_name, $email, $phone, $id) {
        $this->real_name = $real_name;
        $this->email = $email;
        $this->phone = $phone;
        $this->id=$id;
    }

    // Getter methods (optional)
    public function getRealName() {
        return $this->real_name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }
}

class SigningController {


    public function __construct()
    {
        $this->Auth_token = "X-Auth-Token:" . "QhcNFzhao6Pq7YKkJjcom"
        $this->template_ID = 9752;
        $this->Doc_Seal_API = "https://api.docuseal.co/submissions";
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
        CURLOPT_URL => $this->Doc_Seal_API . $signature->Contract_ID,
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
    




public $Auth_token = "X-Auth-Token:" . "QhcNFzhao6Pq7YKkJjcom";
public $template_ID = 9752;
public $Doc_Seal_API = "https://api.docuseal.co/submissions";


$application = new Application("3rd PHP Test", "Description of the art", 500, 'accepted');
$user = new User("Michael Seymour", "Michael.m.seymour@gmail.com", "+13039563185", 123);

$testSign = new SigningController();
$ResponseData = $testSign->createSigning($application, $user);
#print_r ($ResponseData);

if ($ResponseData[0]== null) {
    print_r ("updating object");
    $application->Contract_ID = $ResponseData[1];
    $application->ContractDate = $ResponseData[2];
    $application->Contract_url = "https://docuseal.co/s/" . $ResponseData[3];}
else {
    print_r ("Error returned");
}



print_r ($application);

$status = $testSign->SigningStatus($application);
echo $status;




