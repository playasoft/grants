<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Application;
use App\Models\User;
use App\Models\UserData;
use App\Models\Signature;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\UserController;

class CreateSignature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'signature:create {applicationID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a Contract to sign, updates with details around signature. Pass the application ID and returns contractID if successful or array with error message';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $applicationID = $this->argument('applicationID');
        $application = Application::where ('id', $applicationID)->first();
        $testSign = new SignatureController();
        $signature = $testSign->createSigning($application, $application->user);

        if(isset($signature['error']))
        {
            dump("Error: {$signature['error']}");
            return $signature;
        }
        else
        {
            dump("Contract ID: {$signature->contractID}");
            return $signature->contractID;
        }
    }
}
