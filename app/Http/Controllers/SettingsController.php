<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    // User Management
    public function users()
    {
        $users = User::with('roles')->orderBy('created_at', 'desc')->get();
        $roles = Role::all();
        $adminCount = User::role('admin')->count();
        $firstAdminId = User::role('admin')->orderBy('created_at', 'asc')->value('id');
        $selfId = Auth::id();
        return view('settings.users', compact('users', 'roles', 'adminCount', 'firstAdminId', 'selfId'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|exists:roles,name',
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::create([
            'fullname' => $validated['fullname'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'status' => $validated['status'],
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('settings.users')->with('success', 'User created successfully!');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|exists:roles,name',
            'status' => 'required|in:active,inactive',
        ]);
        // Safety rails to avoid locking out the system
        $incomingRole = $validated['role'];
        $incomingStatus = $validated['status'];
        $isSelf = $user->id === Auth::id();
        $adminCount = User::role('admin')->count();
        $firstAdminId = User::role('admin')->orderBy('created_at', 'asc')->value('id');

        // Primary (first) admin is immutable for ROLE changes (but status can change if not last admin)
        if ($user->id === $firstAdminId) {
            if ($incomingRole !== 'admin') {
                return redirect()->back()->with('error', 'The primary admin account cannot be changed to a non-admin role.');
            }
        }

        // Prevent changing role or status of the last remaining admin
        if ($user->hasRole('admin') && $adminCount <= 1) {
            if ($incomingRole !== 'admin') {
                return redirect()->back()->with('error', 'You cannot change the role of the last admin. Create another admin first.');
            }
            if ($incomingStatus !== 'active') {
                return redirect()->back()->with('error', 'You cannot deactivate the last admin. Create another admin first.');
            }
        }

        // Prevent self-demote and self-deactivate for admins
        if ($isSelf && $user->hasRole('admin')) {
            if ($incomingRole !== 'admin') {
                return redirect()->back()->with('error', 'You cannot change your own role from admin. Ask another admin to make this change.');
            }
            if ($incomingStatus !== 'active') {
                return redirect()->back()->with('error', 'You cannot deactivate your own account.');
            }
        }

        $user->fullname = $validated['fullname'];
        $user->email = $validated['email'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->phone = $validated['phone'] ?? null;
        $user->status = $validated['status'];
        $user->save();

        $user->syncRoles([$validated['role']]);

        return redirect()->route('settings.users')->with('success', 'User updated successfully!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting own account
        if ($user->id === Auth::id()) {
            return redirect()->route('settings.users')->with('error', 'You cannot delete your own account!');
        }

        // Prevent deleting the last remaining admin
        $adminCount = User::role('admin')->count();
        if ($user->hasRole('admin') && $adminCount <= 1) {
            return redirect()->route('settings.users')->with('error', 'You cannot delete the last admin. Create another admin first.');
        }

        // Prevent deleting the primary (first) admin
        $firstAdminId = User::role('admin')->orderBy('created_at', 'asc')->value('id');
        if ($user->id === $firstAdminId) {
            return redirect()->route('settings.users')->with('error', 'You cannot delete the primary admin account.');
        }

        $user->delete();

        return redirect()->route('settings.users')->with('success', 'User deleted successfully!');
    }

    // System Settings
    public function systemSettings()
    {
        $settings = [
            'bakery_name' => SystemSetting::get('bakery_name', 'Cuevas Bakery'),
            'bakery_address' => SystemSetting::get('bakery_address', ''),
            'bakery_phone' => SystemSetting::get('bakery_phone', ''),
            'bakery_email' => SystemSetting::get('bakery_email', ''),
            'operating_hours' => SystemSetting::get('operating_hours', ''),
            'notify_low_stock' => SystemSetting::get('notify_low_stock', '1'),
            'low_stock_threshold' => SystemSetting::get('low_stock_threshold', '10'),
            'notify_orders' => SystemSetting::get('notify_orders', '1'),
            'notify_production' => SystemSetting::get('notify_production', '1'),
        ];

        return view('settings.system', compact('settings'));
    }

    public function updateBakeryInfo(Request $request)
    {
        $validated = $request->validate([
            'bakery_name' => 'required|string|max:255',
            'bakery_address' => 'nullable|string|max:500',
            'bakery_phone' => 'nullable|string|max:20',
            'bakery_email' => 'nullable|email|max:255',
            'operating_hours' => 'nullable|string|max:500',
        ]);

        foreach ($validated as $key => $value) {
            SystemSetting::set($key, $value);
        }

        return redirect()->route('settings.system')->with('success', 'Bakery information updated successfully!');
    }

    public function updateNotifications(Request $request)
    {
        $validated = $request->validate([
            'notify_low_stock' => 'nullable|boolean',
            'low_stock_threshold' => 'required|integer|min:1|max:1000',
            'notify_orders' => 'nullable|boolean',
            'notify_production' => 'nullable|boolean',
        ]);

        // Handle checkboxes - if not checked, they won't be in the request
        SystemSetting::set('notify_low_stock', $request->has('notify_low_stock') ? '1' : '0');
        SystemSetting::set('notify_orders', $request->has('notify_orders') ? '1' : '0');
        SystemSetting::set('notify_production', $request->has('notify_production') ? '1' : '0');
        SystemSetting::set('low_stock_threshold', $validated['low_stock_threshold']);

        return redirect()->route('settings.system')->with('success', 'Notification preferences updated successfully!');
    }

    // Audit Logs
    public function auditLogs()
    {
        $audits = \OwenIt\Auditing\Models\Audit::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('settings.audit-logs', compact('audits'));
    }

    public function testEmail()
    {
        try {
            $to = SystemSetting::get('bakery_email', auth()->user()->email);
            
            Mail::raw('This is a test email from Cuevas Bakery Management System.', function ($message) use ($to) {
                $message->to($to)
                        ->subject('Test Email - Cuevas Bakery');
            });
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
