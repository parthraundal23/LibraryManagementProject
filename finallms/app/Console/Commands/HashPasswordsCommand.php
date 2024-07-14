<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Hash;

class HashPasswordsCommand extends Command
{
    protected $signature = 'hash:passwords';

    protected $description = 'Hash passwords for all users';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->password = bcrypt($user->password);
            $user->save();
        }

        $this->info('Passwords hashed successfully!');
    }
}
