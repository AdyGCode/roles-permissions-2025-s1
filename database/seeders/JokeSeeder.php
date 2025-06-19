<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Joke;
use App\Models\User;
use Illuminate\Database\Seeder;
use Laravel\Prompts\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\ProgressBar;
use function Pest\Laravel\seed;

class JokeSeeder extends Seeder
{
 /**
 * Run the database seeds.
 */
 public function run(): void
 {
 $seedJokes = [
['id'=>1,'title'=> "Skeleton Fight",'body'=> "Why don't skeletons fight each other? They don't have the guts.", 'category'=>['pirate',],],
['id'=>2,'title'=> "Parallel Lines",'body'=> "Parallel lines have so much in common. It's a shame they'll never meet.", 'category'=>['maths',],],
['id'=>3,'title'=> "Embracing Mistakes",'body'=> "I told my wife she should embrace her mistakes. She gave me a hug.", 'category'=>['one-liner',],],
['id'=>4,'title'=> "Broken Pencil",'body'=> "I was going to tell a joke about a broken pencil, but it was pointless.", 'category'=>['one-liner',],],
['id'=>5,'title'=> "Light Sleeper",'body'=> "I told my wife she should stop sleeping in the fridge. She said she's just a light sleeper.", 'category'=>['one-liner',],],
['id'=>6,'title'=> "Elevator Business",'body'=> "I'm thinking of starting a business installing elevators. I hear it has its ups and downs.", 'category'=>['one-liner',],],

     ['title'=>'What is a pirate’s', 'body'=>'What is a pirate’s favourite element? Arrrrrrrrgon', 'category'=>['Science', 'Pirate']],
     ['title'=>'Why did the amoeba fail the', 'body'=>'Why did the amoeba fail the Maths class? Because it multiplied by dividing.', 'category'=>['Science']],
     ['title'=>'Why did the physicist break up', 'body'=>'Why did the physicist break up with the biologist? Because there was no chemistry.', 'category'=>['Science']],
     ['title'=>'What did the mum say to', 'body'=>'What did the mum say to their messy kid? I have a black belt in laundry.', 'category'=>['Mum', 'Kids']],
     ['title'=>'What did the toddler say to', 'body'=>'What did the toddler say to the tired mum? Naptime for you, not me.', 'category'=>['Mum', 'Kids']],
     ['title'=>'What did the ocean say to', 'body'=>'What did the ocean say to the pirate? Nothing. It just waved.', 'category'=>['Pirate']],
     ['title'=>'What is a pirate’s', 'body'=>'What is a pirate’s least favourite vegetable? Leeks.', 'category'=>['Food', 'Pirate']],
     ['title'=>'I used to be a baker', 'body'=>'I used to be a baker… but I could not make enough dough.', 'category'=>['Food', 'Puns']],
     ['title'=>'What types of maths are pirates', 'body'=>'What types of maths are pirates best at? Algebra, because they are good at finding X.', 'category'=>['Pirate', 'Maths']],

 ];


     $output = new ConsoleOutput();
     $progress = new ProgressBar($output, count($seedJokes));
     $progress->start();

      foreach ($seedJokes as $seedJoke) {
         $progress->advance();
         foreach ($seedJoke['category'] as $seedCategory) {
            $category = Category::updateOrCreate(['name'=>$seedCategory,]);
         }

         $joke = Joke::updateOrCreate([
             'user_id' => User::inRandomOrder()->first(),
             'title' => $seedJoke['title'],
             'body' => $seedJoke['body'],
             'category_id' =>$category->id??1,
         ]);

        // If you have set up categories with a many to many then this may help
        // $categoryIds = Category::whereIn('name', $catNames)->pluck('id')->toArray();
        // $joke->categories()->sync($categoryIds);
     }


     $progress->finish();
     $output->writeln("");
 }
}
