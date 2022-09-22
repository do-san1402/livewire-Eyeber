<?php

return [
     'genders' => [
          'Male'   => 1,
          'Female' => 2,
     ],
     'ages' => [10, 20, 30, 40, 50, 60, 70],
     'role_type' => [
          'admin' => 0,
          'customer' => 1,
     ],
     'status' => [
          'success' => 1,
          'fail' => 0,
     ],
     'ads_status' => [
          'hide' => 0, 
          'show' => 1,
     ],      
     'product_upgrade' =>[
          'on' => 1,
          'off' => 0,
     ],
     'status_sales' =>[
          'Sale' => 0,
          'Stop_selling' => 1,
          'Unexposed' => 2
     ],
     'repair_cost' => [
          'Direct_setting' => 1,
          'Auto_setup' => 0,
     ],
     'mining' => [
          'Ratio' => 0,
          'Dose' => 1,
     ],
     'mining_settings' => [
          'direct' => 0,
          'auto' => 1,
     ],
     'advertisement' => [
          'ad_status_id' => 1,
          'views' => 10,
     ],
     'available_coins' => [
          'polygon' => 0,
          'cash_krw' => 1,
          'cash_dollars' => 2,
     ],
     'status_order' =>[
          'completion' => 0,
          'failure' => 1,
          'cancellation' => 2,
     ],
     'category_order' => [
          'purchase' => 0,
          'repair' => 1,
          'upgrade' => 2,
     ],
     'cancellation' => 0,
     'unit_money' => [
          'MATIC' => 0,
          '원' => 1,
          '$' => 2,
     ],
     'status_user' => [
          'waiting_for_certification' => 1,
          'acknowledgement' => 2,
          'standstill' => 3,
          'secession' => 4,
     ],
     'glass_type' => [
          'golden' => 1,
          'silver' => 0.7,
          'bronze' => 0.55,
          'stone' => 0.4,
          'tree' => 0.15,
          'LE2022' => 1.5,
     ],
     'level_limit_product_upgrade' => 29,
     'status_wallet' => [
          'activate' => 0,
          'not_activate' => 1,
     ],
     'cancellation' => [
          'cancel' => 0,
          'continue'=> 1,
     ],
     'durability' => 100,
     'level_coin' => 1,
     'coin_id' => [
          'MATIC' => 1,
          'BMT' => 2,
          'BST' => 3,
     ],
     'status_classification_coin' => [
          'deposit' => 0,
          'withdrawal' => 1,
     ],
     'status_log_coin' =>[
          'wait_for_confirm' => 0,
          'wait_for_withdrawal' => 1,
          'withdrawal_success' => 2,
          'withdrawal_failed' => 3,
          'confirmed' => 4,
          'no_confirm' => 5,
          'deposit_success' => 6,
     ],
     'withdrawal_status' => [
          'wait_for_confirm' => 0,
          'wait_for_withdrawal' => 1,
          'withdrawal_success' => 2,
          'withdrawal_failed' => 3,
     ],
     'glass_category' =>[
          'golden' => 0,
          'silver' => 1,
          'bronze' => 2,
          'stone' => 3,
          'tree' => 4,
          'LE2022' => 5,
     ],
     'mining_settings_auto' => 10,
     'advertising_value' => 10,
     'improvement_index' => 0,
     'mining_value_reduce' => 0.2,
     'status_watch_ad' => [
          'pending' => 0,
          'complete' => 1,
     ],

     
     // durability formula for each glass 1 BMT = 2 BST;   
     'durability_formula_glass' => [
          0 => [
               2 => 5, // key is coin_id ; 
               3 => 10,// key is coin_id ;
          ], // golden

          1 => [
               2 => 4,// key is coin_id ;
               3 => 8,// key is coin_id ;
          ], // silver
          2 => [
               2 => 3,// key is coin_id ;
               3 => 6,// key is coin_id ;
          ],  // bronze
          3  => [
               2 => 2,// key is coin_id ;
               3 => 4,// key is coin_id ;
          ],  // stone
          4  => [
               2 => 1,// key is coin_id ;
               3 => 2,// key is coin_id ;
          ], // tree
          5  => [
               2 => 5, // key is coin_id ; 
               3 => 10,// key is coin_id ;
          ], // LE2022
     ],
     'link_transaction' => 'https://eyeber.onrender.com', 
     'provider_type' => 'testnet' // mainnet or testnet
];