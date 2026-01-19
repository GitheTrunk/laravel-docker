<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSubscriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users
        $samnang = User::where('name', 'samnang')->first();
        $veasna = User::where('name', 'veasna')->first();
        $ratana = User::where('name', 'ratana')->first();

        if (!$samnang || !$veasna || !$ratana) {
            $this->command->error('Users not found. Run AudienceUsersSeeder first.');
            return;
        }

        // Samnang subscribes to:
        $samnangArticles = Article::whereIn('name', [
            'Computers in the next generation',
            'Chemistry in nature form',
            'The origin of water'
        ])->pluck('id');
        
        $samnang->subscribedArticles()->sync($samnangArticles);

        // Veasna subscribes to:
        $veasnaArticles = Article::whereIn('name', [
            'Climate changes in the last 3 years',
            'The origin of water',
            'Quantum computers, is it coming?'
        ])->pluck('id');
        
        $veasna->subscribedArticles()->sync($veasnaArticles);

        // Ratana subscribes to:
        $ratanaArticles = Article::whereIn('name', [
            'Climate changes in the last 3 years',
            'Global warming is in its critical stage'
        ])->pluck('id');
        
        $ratana->subscribedArticles()->sync($ratanaArticles);

        $this->command->info('Article subscriptions created successfully!');
    }
}
