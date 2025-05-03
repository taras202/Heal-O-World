<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Admin Account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->ask('Email ?');
        $password = $this->secret('Password ?');
        $validator = Validator::make([
            'email' => $email,
            'password' => $password,
        ], [
            'email' => 'required|email|max:250|unique:admins',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            $this->info('Admin User not created. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        Admin::create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);
        $this->info('Admin Account created.');

        return 0;
    }
}
