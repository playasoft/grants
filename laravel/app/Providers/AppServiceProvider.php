<?php

namespace App\Providers;

use DB;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;

use App\Misc\Helper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Tell DBAL to treat enums as strings
        DB::connection()
            ->getDoctrineSchemaManager()
            ->getDatabasePlatform()
            ->registerDoctrineTypeMapping('enum', 'string');

        Validator::extend('account', function($attribute, $value, $parameters)
        {
            $user = User::where('name', Input::get('name'))->orWhere('email', Input::get('name'))->first();

            if(!is_null($user))
            {
                return true;
            }

            return false;
        });

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
                $user = User::where('name', Input::get('name'))->orWhere('email', Input::get('name'))->first();

                if(is_null($user))
                {
                    return false;
                }
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
