<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Roster;
use Config;

class CheckRosters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roster:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check open/close rosters';

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
        // $date = Carbon::now()->format('Y-m-d H:i:00');
        $date = Carbon::createFromFormat('Y-m-d H:i:s',  '2021-05-05 15:30:00');
        Roster::where('time_open', '=', $date)->where('status', '=', Config::get('constants.status_roster.PENDING'))->update(['status' => Config::get('constants.status_roster.OPEN')]);
        Roster::where('time_close', '=', $date)->where('status', '=', Config::get('constants.status_roster.OPEN'))->update(['status' => Config::get('constants.status_roster.CLOSE')]);
    }
}
