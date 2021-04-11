<?php namespace Brg\Stock\Updates;

use Faker;
use App;
use October\Rain\Database\Updates\Seeder;
use Brg\Stock\Models\Component as ComponentModel;
use Brg\Stock\Models\Collection as CollectionModel;
use Brg\Stock\Models\Product as ProductModel;

class seedBrgDatabase extends Seeder 
{
    public function run(){
      if( App::environment() <> 'prod' ){
          $faker = Faker\Factory::create('pt_PT');
        
          for($i = 0; $i < 20; $i++) {
            ComponentModel::updateOrCreate([
              'name' => $faker->sentence($nbWords = 2, $variableNbWords = true),
              'category' => $faker->sentence($nbWords = 2, $variableNbWords = true),
              'reference' => $faker->sentence($nbWords = 1, $variableNbWords = true),
              'cost' => $faker->numberBetween($min = 1, $max = 4000),
              'weight' => $faker->numberBetween($min = 0, $max = 300),
              'quantity' => $faker->numberBetween($min = 0, $max = 300),
              'quantity_alert' => $faker->numberBetween($min = 0, $max = 20),
              'supplier_name' => $faker->sentence($nbWords = 2, $variableNbWords = true),
              'is_recyclable' => $faker->numberBetween($min = 0, $max = 1)
            ]);
          }   

          for($i = 0; $i < 5; $i++) {
            CollectionModel::updateOrCreate([
              'name' => $faker->sentence($nbWords = 2, $variableNbWords = true),
              'status' => $faker->numberBetween($min = 0, $max = 1),
              'start_date' => $faker->dateTime($max = 'now', $timezone = null),
              'end_date' => $faker->dateTime($max = '2021-12-31', $timezone = null)
            ]);
          }

          for($i = 0; $i < 20; $i++) {
            ProductModel::updateOrCreate([
              'name' => $faker->sentence($nbWords = 2, $variableNbWords = true),
              'code' => $faker->word(),
              'collection_id' => $faker->numberBetween($min = 0, $max = 5),
              'quantity' => $faker->numberBetween($min = 0, $max = 400),
              'quantity_alert' => $faker->numberBetween($min = 0, $max = 20),
              'silver_quantity' => $faker->numberBetween($min = 0, $max = 300),
              'labour_cost' => $faker->numberBetween($min = 0, $max = 4000),
              'production_status' => $faker->numberBetween($min = 0, $max = 1),
              'stop_selling' => $faker->numberBetween($min = 0, $max = 1)
            ]);
          }  
      }
    } 
}