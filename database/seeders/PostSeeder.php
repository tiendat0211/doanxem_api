<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('posts')->insert([
            'title' => Str::random(10),
            'image' => url('/theme/images/resources/the-only-thing-they-fear-is-you'),
            'share' => 0,
            'post_uuid' => Str::uuid(),
            'status' => 'approval',
            'user_id' => User::factory()
        ]);
    }
}
