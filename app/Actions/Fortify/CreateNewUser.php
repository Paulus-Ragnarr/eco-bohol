<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Manager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'user_role' => ['required', 'string', 'max:255'],
            // 'office' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
        ])->validate();
        
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'user_role' => $input['user_role'],
            // 'office' => $input['office'],
            'position' => $input['position'],
        ]);

        if ($input['user_role'] == 'manager') {
            $manager = Manager::create([
                'manager_id' => $user->user_id,
                'manager_name' => $input['name'],
                'status' => 'disabled',
            ]);
        }

        return $user;
    }
}
