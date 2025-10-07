<?php
namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('roles.index', compact('roles'));
    }
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);
        $permissions = array_filter($validated['permissions'] ?? []);
        unset($validated['permissions']);
        $role = Role::create($validated);
        if (!empty($permissions)) {
            $role->permissions()->attach($permissions);
        }
        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }
    public function show(Role $user_role)
    {
        $user_role->load('permissions', 'users');
        return view('roles.show', compact('user_role'));
    }
    public function edit(Role $user_role)
    {
        $permissions = Permission::all();
        $user_role->load('permissions');
        return view('roles.edit', compact('user_role', 'permissions'));
    }
    public function update(Request $request, Role $user_role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $user_role->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);
        $permissions = $validated['permissions'] ?? [];
        unset($validated['permissions']);
        $user_role->update($validated);
        $user_role->permissions()->sync($permissions);
        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }
    public function destroy(Role $user_role)
    {
        if ($user_role->users()->exists()) {
            return redirect()->route('roles.index')->with('error', 'Cannot delete role with existing users.');
        }
        $user_role->permissions()->detach();
        $user_role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }
}