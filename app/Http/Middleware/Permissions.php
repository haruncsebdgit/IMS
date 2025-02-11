<?php

namespace App\Http\Middleware;

use Closure;

class Permissions
{
    /**
     * Handle an incoming request and permit if permitted to proceed.
     *
     * Special permission containing dynamic CMS permissions
     * regarding content_types, taxonomies, content_id, term_id,
     * and any custom capabilities.
     *
     * USAGE INSTRUCTIONS_______________
     *  Routes (single)_________________
     *      General_____________________
     *          - route::get('users/roles/{role_type?}', 'Users\UserController@indexRole')->middleware('auth', 'permissions:view_users);
     *
     * Routes (multiple)________________
     *  - route::get('users/roles/{role_type?}', 'Users\UserController@indexRole')->middleware('auth', 'permissions:view_users;view_user_roles'); (separate with semicolon)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $caps User Capabilities
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $caps)
    {
        $current_args = $request->route()->parameters();
        // array_shift() is enough as we are passing a single parameter only.
        $current_parameter = array_shift($current_args);

        /**
         * CONVENTION #1
         * Always pass the parameter with curly braces and the string 'parameter'.
         * in case of content_id, pass 'content_id', and
         * in case of term_id, pass 'term_id'
         * ...
         */
        if (strpos($caps, '{parameter}') !== false) {
            $caps = str_replace('{parameter}', $current_parameter, $caps);
        }

        if (strpos($caps, '{content_id}') !== false) {
            $content = getContentById($current_parameter);
            $caps = str_replace('{content_id}', $content->type, $caps);
        }

        if (strpos($caps, '{term_id}') !== false) {
            $term = getTermById($current_parameter);
            $caps = str_replace('{term_id}', $term->taxonomy, $caps);
        }

        /**
         * CONVENTION #2
         * Always separate multiple capabilities using semicolon (;) instead of comma.
         * Known issue: comma (,) breaks the permission string and keep only the first one.
         * ...
         */
        if (strpos($caps, ';') !== false) {
            $caps = explode( ';', $caps );
        }

        // Strict capability checking. Match with all the conditions, don't match with just one.
        if( hasUserCap( $caps, $request->user()->id, true ) ) {
            return $next($request);
        }

        return response('Sorry, You are Unauthorized. Access Denied!', 401);
    }
}
