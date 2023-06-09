<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Image;
use App\Models\User;
use Clockwork\Storage\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => Str::random(10),
            'share' => 0,
            'post_uuid' => Str::uuid(),
            'status' => 'approval',
            'user_id' => User::factory(),
            'image' => 'https://gamek.mediacdn.vn/133514250583805952/2020/10/24/-160349017001950094548.jpeg',
        ];
    }
}
