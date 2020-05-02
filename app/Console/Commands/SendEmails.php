<?php

namespace App\Console\Commands;

use App\Company;
use App\Employee;
use App\Mail\newEmployees;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:new-employees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending Email to companies with new employees who entered to the system this week';

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
        $companies = Company::all();
        foreach ($companies as $company){
            $employees = Employee::where('created_at', '>=', Carbon::now()->subWeek())
                ->where('company_id',$company->id)
                ->get();
            if ($employees->count()){
                $this->sendEmail($company, $employees);
                $this->info('Employees list of this week sent to '.$company->name);
            }
        }
    }

    public function sendEmail($company, $employees)
    {
        Mail::to($company->email)
                ->send(new newEmployees($employees));
    }
}
