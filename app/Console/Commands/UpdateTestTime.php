<?php

namespace App\Console\Commands;

use App\Models\UserTest;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateTestTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:updateTime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update test status';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $usersTests = UserTest::select('user_tests.*')
            ->join('tests', 'tests.id', '=', 'user_tests.test_id')
            ->where('tests.time', '>', 0)
            ->where('user_tests.status', 0)
            ->whereNotNull('user_tests.started_at')
            ->whereNull('user_tests.submitted_at')
            ->whereRaw('user_tests.started_at + INTERVAL `tests`.`time` MINUTE <= now()')
            ->get();

        foreach ($usersTests as $userTest) {
            $userTest->submitted_at = Carbon::now();
            $userTest->status = 1;
            $userTest->save();
        }
        return Command::SUCCESS;
    }
}
