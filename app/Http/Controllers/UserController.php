<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('updated_at', 'DESC')
            ->where('role_id', config('app.user_role_id'))
            ->paginate(config('app.paginate'));

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function enable($id)
    {
        User::findOrFail($id)->update(['is_active' => config('app.is_active')]);
        
        return redirect()->route('users.index')->with('success', __('messages.enable-user-success'));
    }

    public function disable($id)
    {
        User::findOrFail($id)->update(['is_active' => config('app.is_inactive')]);
        
        return redirect()->route('users.index')->with('success', __('messages.disable-user-success'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();

            return redirect()->route('users.index')->with('success', __('messages.delete-user-success'));
        } catch (Exception $ex) {
            return redirect()->route('users.index')->with('error', __('messages.delete-user-failed'));
        }
    }
}
