<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Api\migration\migration;

class DBMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Old Database Tables to new Database';

    protected $migration;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(migration $migration)
    {
        parent::__construct();
        $this->migration = $migration;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $run = true;
        do {
            $db_type = $this->choice('Please choose DB Type?', ['mongo', 'mysql']);
            if ($db_type == 'mongo') {
                $table = $this->choice('Please choose table?', ['Accounts', 'EventNotes', 'UserExperience', 'ExchangeMapping', 'SellerFee', 'UserConfig']);
                $message = $this->migration->mongo_handle($table);
                echo "\n";
                echo $message;
                echo "\n\n";
            } elseif ($db_type == 'mysql') {
                $table = $this->choice('Please choose table?', ['SimpleListing', 'AutoGroupListing', 'ManualGroupListing', 'SeasonGroups', 'EventColors', 'ListingColors', 'CriteriaProfile', 'UserPlan', 'SellerID', 'Keys', 'UserDetail']);
                $truncate = false;
                if ($this->confirm('Do you want to truncate table? [y|n]')) {
                    $truncate = true;
                }
                $message = $this->migration->mysql_handle($table, $truncate);
                echo "\n";
                echo $message;
                echo "\n\n";
            }
            if ($this->confirm('Do you want to migrate another table? [y|n]')) {
                $run = true;
            } else {
                $run = false;
            }
        }  while($run);
    }
}
