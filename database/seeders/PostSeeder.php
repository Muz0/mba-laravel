<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('username', 'admin')->first();

        Post::create([
            'title' => 'Welcome to Laravel CMS',
            'slug' => 'welcome-to-laravel-cms',
            'content' => 'This is your first post in the Laravel CMS. You can edit or delete this post from the admin panel.',
            'author_id' => $admin->id,
        ]);

        Post::create([
            'title' => 'Getting Started Guide',
            'slug' => 'getting-started-guide',
            'content' => 'Learn how to use this CMS by exploring the admin panel. You can create posts, upload media, and manage your content easily.',
            'author_id' => $admin->id,
        ]);
    }
}