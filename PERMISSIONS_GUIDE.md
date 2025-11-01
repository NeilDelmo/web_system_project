# Permissions Guide for Cuevas Bakery System

## Current Permission Structure

### Roles
1. **Admin** - Full system access
2. **Staff** - Limited operational access

### Permissions
| Permission | Admin | Staff | Description |
|------------|-------|-------|-------------|
| `manage_users` | ✅ | ❌ | Create, edit, delete users |
| `manage_inventory` | ✅ | ✅ | Manage products and ingredients |
| `manage_orders` | ✅ | ✅ | Process sales and orders |
| `view_reports` | ✅ | ❌ | View analytics and reports |
| `manage_customers` | ✅ | ✅ | Manage customer information |

---

## Implementation Guide

### 1. **Settings Menu** (ADMIN ONLY)
**Status:** ✅ Already implemented in dashboard.blade.php

```blade
@role('admin')
<li><a class="dropdown-item py-1" href="{{ route('settings.index') }}">
    <i class="bi bi-gear me-1"></i> Settings
</a></li>
@endrole
```

**Why:** Settings contain:
- User Management (manage_users permission)
- System Settings (admin configuration)
- Audit Logs (security/admin feature)

Staff should NOT see or access these features.

---

### 2. **Reports Page** (ADMIN ONLY)
**Current:** Already protected by routes middleware
**File:** `routes/web.php` - Line ~115

```php
Route::get('/reports', [ReportsController::class, 'index'])
    ->middleware('permission:view_reports')
    ->name('reports');
```

**Recommendation:** Hide "Reports" link in sidebar for Staff users

**For all pages with sidebar navigation:**
- dashboard.blade.php
- products.blade.php
- inventory.blade.php
- sales.blade.php
- production.blade.php

**Add this:**
```blade
<a href="/production" class="nav-link"><i class="bi bi-gear-fill me-2"></i>Production</a>
@can('view_reports')
<a href="/reports" class="nav-link"><i class="bi bi-bar-chart-line-fill me-2"></i>Reports</a>
@endcan
```

---

### 3. **Export Functionality** (ADMIN ONLY)
**Current:** Already protected in routes

```php
Route::get('/reports/export/sales/{format}', ...)
    ->middleware('permission:view_reports')
```

**No additional changes needed** - Staff won't see Reports page at all.

---

## Blade Directives for Permissions

### Check by Role
```blade
@role('admin')
    <!-- Only admins see this -->
@endrole

@role('staff')
    <!-- Only staff see this -->
@endrole
```

### Check by Permission
```blade
@can('manage_users')
    <!-- Show user management link -->
@endcan

@can('view_reports')
    <!-- Show reports link -->
@endcan
```

### Check Multiple Roles
```blade
@hasanyrole('admin|staff')
    <!-- Both admin and staff see this -->
@endhasanyrole
```

### Inverse Checks
```blade
@unlessrole('admin')
    <!-- Everyone EXCEPT admin -->
@endunlessrole

@cannot('manage_users')
    <!-- Users WITHOUT manage_users permission -->
@endcannot
```

---

## Recommended Changes by Page

### ✅ **Dashboard** 
- Settings link: HIDDEN for Staff (already done)

### 📝 **All Navigation Pages** (products, inventory, sales, production)
```blade
<!-- Change this: -->
<a href="/reports" class="nav-link"><i class="bi bi-bar-chart-line-fill me-2"></i>Reports</a>

<!-- To this: -->
@can('view_reports')
<a href="/reports" class="nav-link"><i class="bi bi-bar-chart-line-fill me-2"></i>Reports</a>
@endcan
```

### ✅ **Reports Page**
- Already protected by route middleware
- Staff cannot access even with direct URL

### ✅ **Settings Pages** 
- Already protected by `role:admin` middleware in routes
- Settings link hidden in profile dropdown

---

## Testing Permissions

### Test as Admin:
```bash
# Login as admin user
Email: admin@example.com
Password: (your admin password)

# Should see:
✅ Dashboard
✅ Products
✅ Inventory
✅ Sales & Orders
✅ Production
✅ Reports (in sidebar)
✅ Settings (in profile dropdown)
```

### Test as Staff:
```bash
# Login as staff user (create one in Settings > User Management)
Email: staff@example.com
Role: staff

# Should see:
✅ Dashboard
✅ Products
✅ Inventory
✅ Sales & Orders
✅ Production
❌ Reports (HIDDEN in sidebar)
❌ Settings (HIDDEN in profile dropdown)

# If staff tries to access directly:
/reports → 403 Forbidden
/settings → 403 Forbidden
```

---

## Security Best Practices

### ✅ Already Implemented:
1. **Route Middleware** - Backend protection
   ```php
   ->middleware('permission:view_reports')
   ->middleware('role:admin')
   ```

2. **Settings Protection** - All settings routes require admin role

### 📝 Recommended Additions:
1. **Hide UI Elements** - Frontend UX (prevent confusion)
   - Use `@can()` and `@role()` to hide links staff shouldn't see
   
2. **Controller Checks** - Extra validation layer
   ```php
   if (!auth()->user()->hasPermissionTo('manage_users')) {
       abort(403, 'Unauthorized action.');
   }
   ```

---

## Summary

### What Staff CAN Do:
✅ View Dashboard
✅ Manage Products & Inventory
✅ Process Sales & Orders
✅ Handle Production
✅ View their own profile
✅ Logout

### What Staff CANNOT Do:
❌ View Reports/Analytics
❌ Create/Edit/Delete Users
❌ Access Settings
❌ View Audit Logs
❌ Change System Settings
❌ Export Reports

### Implementation Priority:
1. ✅ **DONE:** Settings link hidden for staff
2. ✅ **DONE:** Routes protected with middleware
3. 📝 **TODO:** Hide Reports link in sidebar for staff (optional but recommended)

---

## Next Steps

Would you like me to:
1. Hide the Reports link in all sidebar navigations for staff users?
2. Add permission checks to any specific page?
3. Create additional roles (e.g., "Viewer" role with read-only access)?
4. Add more granular permissions (e.g., separate "view_inventory" and "edit_inventory")?

Let me know what you'd prefer!
