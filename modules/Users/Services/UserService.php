<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Users\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Contracts\Services\CreateService;
use Modules\Core\Contracts\Services\DeleteService;
use Modules\Core\Contracts\Services\Service;
use Modules\Core\Contracts\Services\UpdateService;
use Modules\Core\Facades\Innoclapps;
use Modules\Core\Models\Model;
use Modules\Users\Models\Team;
use Modules\Users\Models\User;

class UserService implements Service, CreateService, UpdateService, DeleteService
{
    public function create(array $attributes): User
    {
        if (isset($attributes['super_admin']) && (bool) $attributes['super_admin'] === true) {
            $attributes['access_api'] = true;
        }

        $attributes['password'] = Hash::make($attributes['password']);

        $user = User::create($attributes);

        if (isset($attributes['notifications'])) {
            Innoclapps::updateNotificationSettings($user, $attributes['notifications']);
        }

        $user->assignRole($attributes['roles'] ?? []);

        collect($attributes['teams'] ?? [])->each(function ($teamId) use ($user) {
            try {
                $user->teams()->attach(Team::findOrFail($teamId));
            } catch (ModelNotFoundException) {
                // In case the team is deleted before the invitation is accepted
            }
        });

        return $user;
    }

    /**
     * Update user in storage.
     *
     * @param  \Modules\Users\Models\User&\Modules\Core\Contracts\Metable  $model
     */
    public function update(Model $model, array $attributes): User
    {
        if (isset($attributes['super_admin']) && (bool) $attributes['super_admin'] === true) {
            $attributes['access_api'] = true;
        }

        if (array_key_exists('password', $attributes)) {
            if (empty($attributes['password'])) {
                unset($attributes['password']);
            } else {
                $attributes['password'] = Hash::make($attributes['password']);
            }
        }

        $model->fill($attributes)->save();

        if (isset($attributes['notifications'])) {
            Innoclapps::updateNotificationSettings($model, $attributes['notifications']);
        }

        if (isset($attributes['roles'])) {
            $model->syncRoles($attributes['roles']);
        }

        return $model;
    }

    public function delete(Model $model, ?int $transferDataTo = null): bool
    {
       if ($model->id === Auth::id()) {
            /**
             * User cannot delete own account
             */
            abort(409, __('users::user.delete_own_account_warning'));
        } elseif ($transferDataTo === $model->id) {
            /**
             * User cannot transfer the data to the same user
             */
            abort(409, __('users::user.delete_transfer_to_same_user_warning'));
        }

        /**
         * The data must be transfered because of foreign keys
         */
        (new TransferUserDataService($transferDataTo ?? Auth::id(), $model->id))();

        /**
         * Detach all the teams the user belongs to
         */
        $model->teams()->detach();

        /**
         * Detach any activities the user is attending to
         */
        $model->guests()->delete();

        /**
         * Purge user non-shared filters
         *
         * Shared filters will be transfered
         */
        $model->filters()->where('is_shared', 0)->delete();

        // Purge user non shared mail templates
        // Share templates will be transferred
        $model->predefinedMailTemplates()->where('is_shared', 0)->delete();

        // Delete all Zapier hooks as this user is no longer applicable
        // for Zapier integration as it's deleted.
        $model->zapierHooks()->delete();

        // Remove user dashboards
        $model->dashboards()->delete();

        /**
         * Delete user personal email accounts
         */
        $model->personalEmailAccounts->each->delete();

        $model->oAuthAccounts->each->delete();

        // Remove the user connected oAuth calendar
        $model->calendar?->delete();

        /**
         * Delete notifications
         */
        $model->notifications()->delete();

        // Delete comments
        $model->comments->each->delete();

        if ($model->avatar) {
            UserAvatarService::remove($model);
        }

        $model->load('visibilityDependents.group');

        $model->visibilityDependents->each(function ($model) {
            $model->group->teams()->detach();
            $model->group->users()->detach();
        });

        return $model->delete();
    }
}
