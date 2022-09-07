<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\User\CreateRequest;
use App\Http\Requests\Auth\User\UpdateRequest;

class UserController extends Controller
{
    
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $users = User::select([
            'users.id',
            'first_name',
            'last_name',
            'email',
            'last_login',
            'users.created_at',
            'users.updated_at',
        ])
        ->with('roles', 'activations')
        ->paginate();
       
        return view('admin.auth.user.index', compact('users'));
    }

    
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $roleDb = Role::select('id', 'name')
            ->get();

        return view('admin.auth.user.create', array(
            'roleDb' => $roleDb,
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(CreateRequest $request)
    {
        //dd($request);
        $email = $request->email;
        $user  = Sentinel::getUser()->first_name;

        DB::beginTransaction();
        try {
            $data = [
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => strtolower($email),
                'password'   => $request->password,
                'phone'   => $request->phone,
                'created_by' => $user,
                'updated_by' => $user,
            ];

            //Create a new user
            $user = Sentinel::registerAndActivate($data);

            //Attach the user to the role
            $role = Sentinel::findRoleById($request->role);
            $role->users()
                ->attach($user);

            DB::commit();

            Session::flash('success', __('auth.account_creation_successful'));

            return redirect()->route('users.index');
        } catch (\Exception $exception) {
            DB::rollBack();

            Session::flash('failed', $exception->getMessage() . ' ' . $exception->getLine());

            return redirect()
                ->back()
                ->withInput($request->all());
        }
    }

    
    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $user = Sentinel::findUserById($id);

        if (empty($user)) {
            Session::flash('failed', __('global.not_found'));

            return redirect()->route('users.index');
        }

        $roleDb = Role::select('id', 'name')
            ->get();

        $userRole = $user->roles[0]->id ?? null;

        return view('admin.auth.user.update', array(
            'data'     => $user,
            'roleDb'   => $roleDb,
            'userRole' => $userRole
        ));
    }

   
    /**
     * @param UpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        $user = Sentinel::findById($id);

        if (empty($user)) {
            Session::flash('failed', __('global.not_found'));

            return redirect()->route('users.index');
        }

        DB::beginTransaction();
        try {
            $oldRole = Sentinel::findRoleById($user->roles[0]->id ?? null);

            $credentials = [
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
            ];

            #If User Input Password
            if ($request->password) {
                $validator = Validator::make($request->all(), [
                    'password' => 'min:8',
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
                }

                $credentials['password'] = $request->password;
            }

            #Valid User For Update
            $role = Sentinel::findRoleById($request->role);

            if ($oldRole) {
                #Remove a user from a role.
                $oldRole->users()
                    ->detach($user);
            }

            #Assign a user to a role.
            $role->users()
                ->attach($user);

            #Update User
            Sentinel::update($user, $credentials);

            DB::commit();

            Session::flash('success', __('auth.update_successful'));

            return redirect()->route('users.index');
        } catch (\Exception $exception) {
            DB::rollBack();

            Session::flash('failed', $exception->getMessage() . ' ' . $exception->getLine());

            return redirect()
                ->back()
                ->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('user_id', 0);
        
        $user = Sentinel::findById($id);

        if (empty($user)) {
            Session::flash('failed', __('global.not_found'));

            return redirect()->route('users.index');
        }

        $user->delete();

        Session::flash('success', __('auth.delete_account'));

        return redirect()->route('users.index');
    }

    
    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function status($id)
    {
        $user = Sentinel::findById($id);

        $activation = Activation::completed($user);

        #Remove activation code
        Activation::remove($user);

        if ($activation !== false) {
            #Deactivated This Activation
            if ($user->id === Sentinel::getUser()->id) {
                Session::flash('failed', __('auth.deactivate_current_user_unsuccessful'));

                return redirect()->route('users.index');
            }

            Session::flash('success', __('auth.deactivate_successful'));

            return redirect()->back();
        }

        #Own User Cannot Change The User Status
        if ($user->id === Sentinel::getUser()->id) {
            Session::flash('failed', __('auth.active_current_user_unsuccessful'));

            return redirect()->back();
        }

        #Get Activation Code
        $activationCreate = Activation::create($user);

        #Activate this account
        Activation::complete($user, $activationCreate->code);

        Session::flash('success', __('auth.activate_successful'));

        return redirect()->back();
    }
}
