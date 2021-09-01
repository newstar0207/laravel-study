<?php

namespace Database\Factories;

use App\Models\PostUser;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostUserFactory extends Factory
{

    protected $user_id = null;
    protected $post_id = null;

    public function __construct()
    {
        parent::__construct();
        $this->user_id = User::all();
        $this->post_id = Post::all();
    }

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $userId = $this->user_id->random()->id;
            $postId = $this->post_id->random()->id;
            $postUser = PostUser::where('user_id', $userId)->where('post_id', $postId);
        } while ($postUser->count() != 0);

        return [
            'user_id' => $this->userId,
            'post_id' => $this->postID,
        ];

        // return [
        //     'user_id' => function (array $attributes) {
        //         return User::find($attributes['user_id'])->random();
        //     },
        //     'post_id' => function (array $attributes) {
        //         return Post::find($attributes['post_id'])->random();
        //     },
        // ];
    }
}
