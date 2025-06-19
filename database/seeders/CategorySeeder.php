<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seedCategories = [
            ['id'=>9, 'name'=>'geek', 'created_at'=>'2020-01-09 00:00:02',],
            ['id'=>10, 'name'=>'programmer', 'created_at'=>now(),],
            ['id'=>2, 'name'=>'web', 'created_at'=>'2020-01-02 00:00:02',],
            ['id'=>3, 'name'=>'knock-knock', 'created_at'=>'2020-01-03 00:00:03',],
            ['id'=>4, 'name'=>'rude', 'created_at'=>'2020-01-04 00:00:04',],
            ['id'=>5, 'name'=>'dog', 'created_at'=>'2020-01-05 00:00:05',],
            ['id'=>6, 'name'=>'cat', 'created_at'=>'2020-01-06 00:00:06',],
            ['id'=>7, 'name'=>'halloween', 'created_at'=>'2020-01-07 00:00:07',],
            ['id'=>8, 'name'=>'animal', 'created_at'=>'2020-01-08 00:00:08',],
            ['id'=>1, 'name'=>'unknown', 'created_at'=> '2020-01-01 00:00:01'],
            ['id'=>11, 'name'=>'dad', 'created_at'=> now()],
        ];

        foreach ($seedCategories as $seedCategory) {
            Category::updateOrCreate($seedCategory);
        }
    }
}
