<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            $image=$this->faker->image(storage_path('app/public'),width: 100,height:100,fullPath: false);
        $userId=DB::table('users')->pluck('id')->toArray();

        return [
            'title'=>fake()->jobTitle(),
            'description'=>fake()->realText(20),
            'image' => $image,
            'createdBy'=>fake()->randomElement($userId),
            'created_at'=>now(),
            'updated_at'=>now()
        ];
    }
}
