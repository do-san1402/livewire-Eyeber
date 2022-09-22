<?php

namespace App\Console\Commands;

use App\Models\Coin;
use App\Models\User;
use App\Services\Wallets\WalletService;
use Illuminate\Console\Command;

class UpdateBalanceJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:balanceUserWallet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update balance user wallet ';

    private $walletService;


    public function __construct(WalletService $walletService)
    {
        parent::__construct();
        $this->walletService = $walletService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::query()->where('role_type', config('apps.common.role_type.customer'))->get();
        $coins = Coin::all();
        foreach($users as $user){
            foreach($coins as $coin){
                $data = $this->walletService->updatebalance($user->id, $coin->id);
            }  
        }
    }
}