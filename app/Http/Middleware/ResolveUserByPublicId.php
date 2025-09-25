<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveUserByPublicId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $publicId = $request->query('public_id', $request->input('public_id'));

        abort_unless($publicId, 422, 'public_id is required');

        $user = User::where('public_id', $publicId)->first();
        abort_unless($user, 404, 'User not found');

        // attach once; controllers can grab it
        $request->attributes->set('user', $user);

        return $next($request);
    }
}
