<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Application;
use App\Models\Signature;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SignatureController;

class CheckSigStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'signature:check {contractID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the status of a signature';

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
        //pass the Contract ID to look up the contract, check status and then update object and returns the status.
        $contractID = $this->argument('contractID');
        $signature = Signature::where ('contractID', $contractID)->first();
        $testSign = new SignatureController();
        $status = $testSign->signingStatus($signature);

        print_r ($status);
        return $status;
    }
}
