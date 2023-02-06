<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fruit;

class fruitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fruitNames = [
            'Apple', 'Orange', 'Banana',
            'Pear', 'StrawBerry'
        ];

        foreach($fruitNames as $fruitName) {
            $fruit = new Fruit;
            $fruit->name = $fruitName;
            $fruit->save();
        }
    }
}
