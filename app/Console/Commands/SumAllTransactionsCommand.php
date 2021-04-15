<?php
namespace App\Console\Commands;

use App\Actions\CalculateTotalAmountOfTransactionsAction;
use Illuminate\Console\Command;

/**
 * Class IndexInMongoFromJson
 * @package App\Console\Commands
 */
class SumAllTransactionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:sum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sum all transaction records amount value and prints it in console';

    /**
     * Create a new command instance.
     *
     * @param LocationMongoRepository $mongoRepo
     * @param LocationHydrator $locationHydrator
     * @return void
     */
    public function __construct(private CalculateTotalAmountOfTransactionsAction $action)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Calculating sum of all records ...");
        $this->info("---------------------------------------------------------------------------------");
        $this->info($this->action->__invoke());
        $this->info("---------------------------------------------------------------------------------\n");
    }



}