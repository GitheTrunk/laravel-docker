<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Author;
use App\Models\Audience;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users
        $sokUser = User::whereHas('author', function($q) {
            $q->where('name', 'Sok');
        })->first();
        
        $saoUser = User::whereHas('author', function($q) {
            $q->where('name', 'Sao');
        })->first();

        $samnangUser = User::where('name', 'samnang')->first();
        $veasnaUser = User::where('name', 'veasna')->first();

        if (!$sokUser || !$saoUser || !$samnangUser || !$veasnaUser) {
            $this->command->error('Required users not found');
            return;
        }

        // 1. Author Sok commented on his article "Climate changes in the last 3 years"
        $climateArticle = Article::where('name', 'Climate changes in the last 3 years')->first();
        if ($climateArticle) {
            Comment::create([
                'content' => 'Thank you to all the subscribers',
                'user_id' => $sokUser->id,
                'commentable_id' => $climateArticle->id,
                'commentable_type' => Article::class,
            ]);
        }

        // 2. Audience Samnang commented on author Sao
        $saoAuthor = Author::where('name', 'Sao')->first();
        if ($saoAuthor) {
            Comment::create([
                'content' => 'Your article is amazing',
                'user_id' => $samnangUser->id,
                'commentable_id' => $saoAuthor->id,
                'commentable_type' => Author::class,
            ]);
        }

        // 3. Author Sao commented on Audience Samnang
        $samnangAudience = Audience::where('user_id', $samnangUser->id)->first();
        if ($samnangAudience) {
            Comment::create([
                'content' => 'Welcome to read my article',
                'user_id' => $saoUser->id,
                'commentable_id' => $samnangAudience->id,
                'commentable_type' => Audience::class,
            ]);
        }

        // 4. Audience Veasna commented on article "Quantum computers, is it coming?"
        $quantumArticle = Article::where('name', 'Quantum computers, is it coming?')->first();
        if ($quantumArticle) {
            Comment::create([
                'content' => "I can't wait this thing happening",
                'user_id' => $veasnaUser->id,
                'commentable_id' => $quantumArticle->id,
                'commentable_type' => Article::class,
            ]);
        }

        $this->command->info('Comments seeded successfully!');
    }
}
