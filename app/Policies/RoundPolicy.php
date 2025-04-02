<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\Round;
use Illuminate\Auth\Access\Response;

class RoundPolicy
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
    public function view(Company $company, Round $round): bool
    {
        return $company->id === $round->project->company_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Company $company): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Company $company, Round $round): bool
    {
        return $company->id === $round->project->company_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Company $company, Round $round): bool
    {
        return $company->id === $round->project->company_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Company $company, Round $round): bool
    {
        return $company->id === $round->project->company_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Company $company, Round $round): bool
    {
        return $company->id === $round->project->company_id;
    }
}
