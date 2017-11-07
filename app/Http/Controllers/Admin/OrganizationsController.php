<?php

namespace App\Http\Controllers\Admin;

use App\Organization;
use App\User;
use Silber\Bouncer\Database\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrganizationsRequest;
use App\Http\Requests\Admin\UpdateOrganizationsRequest;

class OrganizationsController extends Controller
{
    /**
     * Display a listing of Organization.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('organizations_manage')) {
            return abort(401);
        }

        $organizations = Organization::all();

        return view('admin.organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating new Organization.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('organizations_manage')) {
            return abort(401);
        }
        $users = User::all()->pluck('name', 'id');

        return view('admin.organizations.create', compact('users'));
    }

    /**
     * Store a newly created Organization in storage.
     *
     * @param  \App\Http\Requests\StoreOrganizationsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrganizationsRequest $request)
    {
        if (!Gate::allows('organizations_manage')) {
            return abort(401);
        }

        $organization = Organization::create($request->all());
        $organization->users()->attach($request->input('users'));

        return redirect()->route('admin.organizations.index');
    }


    /**
     * Show the form for editing Organization.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('organizations_manage')) {
            return abort(401);
        }

        $organization = Organization::findOrFail($id);
        $users = User::all()->pluck('name', 'id');

        return view('admin.organizations.edit', compact('organization', 'users'));
    }

    /**
     * Update Organization in storage.
     *
     * @param  \App\Http\Requests\UpdateOrganizationsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrganizationsRequest $request, $id)
    {
        if (!Gate::allows('organizations_manage')) {
            return abort(401);
        }

        $organization = Organization::findOrFail($id);
        $organization->update($request->all());
        $organization->users()->sync($request->input('users'));

        return redirect()->route('admin.organizations.index');
    }

    /**
     * Remove Organization from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('organizations_manage')) {
            return abort(401);
        }
        $organization = Organization::findOrFail($id);
        $organization->delete();

        return redirect()->route('admin.organizations.index');
    }

    /**
     * Delete all selected Organization at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('organizations_manage')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Organization::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
