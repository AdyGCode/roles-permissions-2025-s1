<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(?User $user, Post $post): bool
    {
dd($user);
        // visitors cannot view unpublished items
        if ($user === null) {
            return Response::deny('You must be a member to view posts.');;
        }

        if ($post->published) {
            return Response::allow();
        }

        // admin overrides published status
        if ($user->can('view any unpublished posts')) {
            return Response::allow();
        }

        // authors can view their own unpublished posts
        if ($user->id == $post->user_id) {
            return Response::allow();
        };

        return Response::deny('Error: problem with permission to view post.');;

    }

    public function create(User $user): bool
    {
        return $user->can('create posts');
    }

    public function update(User $user, Post $post): bool
    {

        if ($user->can('edit all posts')) {
            return Response::allow();
        }

        if ($user->can('edit own posts')) {
            if ($user->id == $post->user_id) {
                return Response::allow();
            };
        }

        return Response::deny('You do not own this post.');;
    }

    public function delete(User $user, Post $post): bool
    {
        if ($user->can('delete any post')) {
            return true;
        }

        if ($user->can('delete own posts')) {
            return $user->id == $post->user_id;
        }

        return false;

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return $user->can('restore post');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return $user->can('trash post');
    }
}
