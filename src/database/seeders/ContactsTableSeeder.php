<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Category;


class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryIds = Category::pluck('id')->all();
        Contact::factory(35)->create([
            'category_id' => function () use ($categoryIds) {
                return collect($categoryIds)->random();
            }
        ]);
    }
}
