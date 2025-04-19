<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Redirect to admin login if the request is for an admin route
            if (str_starts_with($request->path(), 'admin')) {
                return route('admin.login');
            }
            
            // For other routes, you can define a default login route
            // or just use the admin login route for all authentication
            return route('admin.login');
        }
        
        return null;
    }
}
