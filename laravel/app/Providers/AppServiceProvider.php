<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Validator function to check password hashes
        Validator::extend('hashed', function($attribute, $value, $parameters)
        {
            // If we're already logged in
            if(Auth::check())
            {
                $user = Auth::user();
            }
            else
            {
                // Otherwise, try to get the username from form input
                $user = User::where('name', Input::get('name'))->get();

                if(!$user->count())
                {
                    return false;
                }

                $user = $user[0];
            }
            
                
            if(Hash::check($value, $user->password))
            {
                return true;
            }
            
            return false;
        });

        // Define polymorphic relationship models
        Relation::morphMap(
        [
            'question' => \App\Models\Question::class,
            'document' => \App\Models\Document::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
