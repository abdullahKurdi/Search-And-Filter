<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create(['name'=>'iphone 6+']);
        Tag::create(['name'=>'iphone 6s+']);
        Tag::create(['name'=>'iphone 7+']);
        Tag::create(['name'=>'iphone 8']);
        Tag::create(['name'=>'iphone 8+']);
        Tag::create(['name'=>'samsung a21']);
        Tag::create(['name'=>'samsung s9+']);
        Tag::create(['name'=>'samsung note 9+']);
        Tag::create(['name'=>'nokia s2']);
        Tag::create(['name'=>'nokia c5']);
    }
}
