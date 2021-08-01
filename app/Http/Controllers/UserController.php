<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('name', 'LIKE', "%{$value}%")->orWhere('email', 'LIKE', "%{$value}%");
            });
        });
        $dataUser = User::with('roles');
        $users = QueryBuilder::for($dataUser)
            ->defaultSort('name')
            ->allowedSorts(['name', 'email','status','role'])
            ->allowedFilters(['name', 'email','status','role', $globalSearch])
            ->paginate()
            ->withQueryString()
              ->through(fn ($users) => [
                    'id'=>$users->id,
                    'name'=>$users->name,
                    'email'=>$users->email,
                    'status'=>$users->status,
                    'role'=>$users->roles ? $users->roles->pluck('name') : null,
              ]);
        // dd($users);
        return Inertia::render('IndexUser', [
            'users' => $users,
        ])->table(function (InertiaTable $table) {
            $table->addSearchRows([
                'email' => 'Email address',
                 'email' => 'Email address',
            ])->addFilter('status', 'status', [
                'Active' => 'Active',
                'Nonactive' => 'Nonactive',
            ])->addColumns([
                'email' => 'Email address',
                'name' => 'Name',
                'role'=>'Role',
                'status'=>'Status',
            ]);
        });
    }

    public function create()
    {
        return Inertia::render('AddUser', [
            'organizations' => Role::orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }
}
