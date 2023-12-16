<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // customer
			['name' => 'customer.view'],
			['name' => 'customer.create'],
			['name' => 'customer.delete'],

            ['name' => 'supplier.view'],
            ['name' => 'supplier.create'],
            ['name' => 'supplier.delete'],


            ['name' => 'productInitialize.view'],
            ['name' => 'productInitialize.create'],
            ['name' => 'productInitialize.delete'],

            ['name' => 'inventoryItem.view'],
            ['name' => 'inventoryItem.create'],
            ['name' => 'inventoryItem.delete'],

            ['name' => 'purchase.view'],
            ['name' => 'purchase.create'],
            ['name' => 'purchase.delete'],

            ['name' => 'sale.view'],
            ['name' => 'sale.create'],
            ['name' => 'sale.delete'],

            ['name' => 'account.view'],
            ['name' => 'account.create'],
            ['name' => 'account.delete'],

            ['name' => 'paymentAccount.create'],


            ['name' => 'voucher.view'],
            ['name' => 'voucher.create'],
            ['name' => 'voucher.delete'],

            ['name' => 'user.view'],
            ['name' => 'user.create'],
            ['name' => 'user.delete'],

            ['name' => 'vehicle.view'],
            ['name' => 'vehicle.create'],
            ['name' => 'vehicle.delete'],

            ['name' => 'vehicleIncomeExpense.view'],
            ['name' => 'vehicleIncomeExpense.create'],
            ['name' => 'vehicleIncomeExpense.delete'],

            ['name' => 'role.view'],
            ['name' => 'role.create'],
            ['name' => 'role.delete'],

            ['name' => 'report.view'],

            ['name' => 'settings.view'],
        ];

        $insert_data = [];
		$time_stamp = Carbon::now();
		foreach ($data as $d) {
			$d['guard_name'] = 'web';
			$d['created_at'] = $time_stamp;
			$insert_data[] = $d;
		}
		Permission::insert($insert_data);
    }
}
