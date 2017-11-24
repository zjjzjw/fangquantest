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
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ChinaAreaSeeder::class);
        $this->call(ChinaAreaSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(MeasureunitSeeder::class);
        $this->call(DeveloperProjectStageSeeder::class);
        $this->call(PlatformSeeder::class);
        $this->call(RegisterTypeSeeder::class);
        $this->call(ProductCategorySeeder::class);
    }

}
