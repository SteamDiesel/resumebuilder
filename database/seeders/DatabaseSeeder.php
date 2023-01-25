<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Employer;
use App\Models\Paragraph;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(1)->create();


        $user = User::factory()
            ->hasEmployers(2)
            ->create([
            'name' => 'Jason',
            'email' => 'test@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        foreach($user->employers as $e){
            $roles = Role::factory()->count(1)->create(['user_id'=>$user->id, 'employer_id' => $e->id]);
            foreach($roles as $r){
                $paragraphs = Paragraph::factory()->count(4)->create(['user_id' => $user->id]);
                $arr = $paragraphs->pluck('id');
                $r->paragraph_order = $arr;
                $r->save();
            }
        }
    }
}
