<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Mailing\ReminderController;

class SendReminderForSelfReflection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:selfReflectionReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder for survey Self Reflection';

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
        ReminderController::reminderForSelfReflection();
    }
}
