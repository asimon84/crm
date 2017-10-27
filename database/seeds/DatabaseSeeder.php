<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Miscellaneous
        $this->call(UsersTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(CardAssociationsTableSeeder::class);
        $this->call(IssuersTableSeeder::class);
        $this->call(BINsTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(ReasonCodesTableSeeder::class);

        //Dashboard
        $this->call(DashboardPermissionsTableSeeder::class);
        $this->call(DashboardAgentPermissionsTableSeeder::class);

        //Clients
        $this->call(ClientsTableSeeder::class);
        $this->call(ClientsServicesTableSeeder::class);
        $this->call(ClientsPermissionsTableSeeder::class);
        $this->call(ClientsAgentPermissionsTableSeeder::class);

        //Products
        $this->call(ProductTypesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ProductsPermissionsTableSeeder::class);
        $this->call(ProductsAgentPermissionsTableSeeder::class);

        //MIDs
        $this->call(MIDsTableSeeder::class);
        $this->call(MIDsPermissionsTableSeeder::class);
        $this->call(MIDsAgentPermissionsTableSeeder::class);

        //Orders
        $this->call(OrdersTableSeeder::class);
        $this->call(OrdersPermissionsTableSeeder::class);
        $this->call(OrdersAgentPermissionsTableSeeder::class);
    }
}
