<?php

namespace App\Console\Commands;

use App\Mail\CarPickup;
use App\Mail\CommentPosted;
use App\Mail\CommunityCreated;
use App\Mail\CompanySelected;
use App\Mail\DownloadHistory;
use App\Mail\GarageRepair;
use App\Mail\NewCarCreated;
use App\Mail\Product;
use App\Mail\QuoteAccepted;
use App\Mail\RecoveryCompanyNotice;
use App\Mail\RecoveryCreated;
use App\Mail\RecoveryQuoteReceived;
use App\Mail\RepairCreated;
use App\Mail\RepairQuoteReceived;
use App\Mail\ServiceCreated;
use App\Mail\ServiceReminder;
use App\Mail\UserAddedToCompany;
use App\Mail\WelcomeMail;
use App\Models\CarInfo;
use App\Models\Community;
use App\Models\CommunityComment;
use App\Models\Garage;
use App\Models\MarketPlace;
use App\Models\MotAppointment;
use App\Models\Recovery;
use App\Models\RecoveryQuote;
use App\Models\RepairAppointment;
use App\Models\ServiceAppointment;
use App\Models\User;
use App\Scopes\ActiveGarageScope;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use PDF;

class SendTestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::first();

        Mail::to($user)->send(new WelcomeMail($user));

        $this->info('Mail send');
    }
}
