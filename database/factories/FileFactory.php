<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'user_id' => User::factory(),
            'fileable_id' => Post::factory(),
            'fileable_type' => Post::class,
            'file_uuid' => Str::uuid(),
            'url' => 'https://gamek.mediacdn.vn/133514250583805952/2020/10/24/-160349017001950094548.jpeg',
            'file_type' => 'image',
        ];
    }
}
