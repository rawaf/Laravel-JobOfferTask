<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class newEmployees extends Mailable
{
    use Queueable, SerializesModels;

    private $employees;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employees)
    {

        $this->employees = $employees;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $employees = $this->employees;
        return $this->view('emails.new-employees')->with(compact('employees'));
    }
}
