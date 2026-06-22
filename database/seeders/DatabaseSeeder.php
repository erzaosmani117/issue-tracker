<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Project;
use App\Models\Issue;
use App\Models\Tag;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    

      public function run(): void
{
    $tags = Tag::factory(10)->create();
    
    Project::factory(5)->create()->each(function ($project) use ($tags) {
        Issue::factory(3)->create(['project_id' => $project->id])->each(function ($issue) use ($tags) {
            Comment::factory(3)->create(['issue_id' => $issue->id]);
            $issue->tags()->attach($tags->random(2)->pluck('id'));
        });
    });
}
    
}
