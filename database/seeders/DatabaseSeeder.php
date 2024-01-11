<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Sub_category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Admin::create([
             'name' => 'SNDK',
             'email' => 'mehul.sndkcorp@gmail.com',
             'username' => 'sndkcorp',
             'password' => Hash::make('12345678'),
         ]);

        $category = Category::create(['name' => 'Men']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'T-Shirts']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Jeans']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Casual Shoes']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Sports Shoes']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Trousers']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Sandals']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Belts']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Formal Shirts']);
  
        $category = Category::create(['name' => 'Women']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Sarees']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Skirts']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Palazzos']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Tops']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Sports Shoes']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Kurta & Suits Kurtis']);
  
        $category = Category::create(['name' => 'Kids']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Shirts']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'T-Shirts']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Shorts']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Value Packs']);

        $category = Category::create(['name' => 'Home & Living']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Bath & Towels']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Beach Towels']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Bedsheets']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Bedding Sets']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Bed Covers']);
        $sub_category = Sub_category::create(['category_id' => $category->id, 'name' => 'Diwan Sets']);
  
    }
}
