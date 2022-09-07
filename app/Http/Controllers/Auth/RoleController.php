<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\Role\createRequest;
use App\Http\Requests\Auth\Role\updateRequest;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class RoleController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $roles = Role::select([
            'id',
            'slug',
            'name',
            'created_at',
            'updated_at',
        ])->paginate();
        return view('admin.auth.role.index', compact('roles'));
    }


    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        return view('admin.auth.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param createRequest $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(CreateRequest $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->slug = Str::slug($request->name);

        $permissions = collect(json_decode($this->permissions($request)))->toArray();
        $role->permissions = $permissions;

        $role->save();

        Session::flash('success', __('admin.auth.role_creation_successful'));

        return redirect()->route('roles.index');
    }




    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $role = Role::find($id);

        if (empty($role)) {
            Session::flash('failed', __('global.denied'));

            return redirect()->back();
        }

        $permission = json_decode(json_encode($role->permissions), true);

        return view('admin.auth.role.update', array(
            'dataDb'      => $role,
            'permissions' => $permission
        ));
    }


    /**
     * @param UpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        $role = Role::find($id);

        if (empty($role)) {
            Session::flash('failed', __('global.denied'));

            return redirect()->back();
        }

        $role->name = $request->name;

        /**
         *  Permission Here
         */
        $permissions = collect(json_decode($this->permissions($request)))->toArray();
        $role->permissions = $permissions;
        $role->save();

        Session::flash('success', __('admin.auth.role_update_successful'));

        return redirect()->route('roles.index');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $id = $request->input('role_id', 0);
        $user = Sentinel::getUser();
        $role = Sentinel::findRoleById($id);

        if (empty($role)) {
            Session::flash('failed', __('global.not_found'));

            return redirect()->route('roles.index');
        }

        $role->users()
            ->detach($user);
        $role->delete();

        Session::flash('success', __('auth.delete_account'));

        return redirect()->route('roles.index');
    }


    /**
     * @param Request $request
     * @return string
     */
    private function permissions(Request $request)
    {

        //Dashboard
        $permissions['dashboard'] = true;

        $request = $request->except(array('_token', 'name', '_method', 'previousUrl'));

        foreach ($request as $key => $value) {
            $permissions[preg_replace('/_([^_]*)$/', '.\1', $key)] = true;
        }

        return json_encode($permissions);
    }


    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function duplicate($id)
    {
        $role = Role::where('id', $id)->firstOrFail();

        $permission = json_decode(json_encode($role->permissions), true);

        return view('admin.auth.role.duplicate', ['data' => $role, 'permissions' => $permission]);
    }
}
