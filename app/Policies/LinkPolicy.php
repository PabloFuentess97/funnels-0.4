<?php

namespace App\Policies;

use App\Models\Link;
use App\Models\Company;
use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\Response;

class LinkPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Company $company): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Company $company, Link $link): bool
    {
        return $company->id === $link->project->company_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Project $project): bool
    {
        return $user->company_id === $project->company_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Link $link): bool
    {
        return $user->company_id === $link->project->company_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Link $link): bool
    {
        return $user->company_id === $link->project->company_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Company $company, Link $link): bool
    {
        return $company->id === $link->project->company_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Company $company, Link $link): bool
    {
        return $company->id === $link->project->company_id;
    }
}
