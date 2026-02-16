# Pasar Management System - AI Agent Instructions

## Project Overview
A Laravel 7 application for managing Indonesian marketplaces (pasar), vendors (pedagang), and stall transactions. The system handles role-based access control, market administration, vendor registration, and transaction management.

## Architecture Patterns

### Controller Structure
All controllers follow a standard pattern with protected properties and resource methods:

```php
protected $route = 'master-pasar.pasar.';  // Route name prefix
protected $view  = 'pages.masterPasar.pasar.';  // View path
protected $title = 'Pasar';  // Display title for messages

// Standard methods: index(), api(), show(), store(), update(), edit(), destroy()
```

Controllers are organized by module namespaces: `MasterPasar`, `MasterPedagang`, `MasterRole`, `MasterTransaksi`, `MasterJenis`.

### Data Table Pattern
All listings use [Yajra DataTables](https://yajrabox.com/docs/laravel-datatables) with AJAX endpoints:
- List view calls `api()` method via POST to `{route}.api`
- Controllers return DataTables JSON with `->addColumn()`, `->editColumn()`, `->rawColumns()`, `->toJson()`
- Action columns use inline onclick handlers: `onclick='edit({id})'`, `onclick='remove({id})'`

### Indonesian Location Hierarchy
The system manages a four-tier administrative structure:
- **Provinsi** (Province) → **Kabupaten** (Regency) → **Kecamatan** (District) → **Kelurahan** (Village)
- Models: `Provinsi`, `Kabupaten`, `Kecamatan`, `Kelurahan` with cascading dropdowns in forms
- Methods like `kabupatenByProvinsi($id)`, `kecamatanByKabupaten($id)` provide dependent data

### Database Conventions
- Tables use `tm_` prefix (e.g., `tm_pasars`, `tm_pedagangs`)
- Indonesian field names: `nm_pasar` (name), `kd_pasar` (code), `id_kel` (village ID), `id_kab` (regency ID)
- Foreign keys follow `{table}_id` pattern with Eloquent relationships defined as `belongsTo()`

### View Structure
- Main layout: `resources/views/layouts/app.blade.php`
- Views organized by module: `pages/masterPasar/`, `pages/masterPedagang/`, etc.
- Template configuration stored in `Template` model with logo/branding fetched in layout
- User authentication shows current user via `Auth::user()->admin_detail[0]->foto`

### Role-Based Access Control
Uses [Spatie Laravel Permission](https://github.com/spatie/laravel-permission):
- Route groups with middleware: `['auth', 'role:super-admin']`
- Permission management at `/master-roles/role/{id}/addPermissions`
- Models: `ModelHasRoles`, `RoleHasPermissions`

## Development Workflow

### Local Environment
- **Laragon** on Windows (d:\laragon\www\pasar)
- Database: MySQL via Laragon
- Assets compiled with Laravel Mix: `npm run dev` / `npm run watch`

### Essential Commands
```bash
# Start development
php artisan serve  # Usually via Laragon auto-start

# Database
php artisan migrate
php artisan db:seed

# Assets
npm run dev        # Development build
npm run watch      # Watch for changes

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### Key Dependencies
- **laravel/framework**: ^7.24
- **spatie/laravel-permission**: ^3.16 (roles & permissions)
- **yajra/laravel-datatables-oracle**: ^9.10 (server-side tables)
- **laravel/ui**: ^2.2 (authentication scaffolding)
- Frontend: Bootstrap 4, jQuery, custom templates in `public/assets/`

### Production Configuration (HTTPS)
The application runs on `https://pasar.tangerangselatankota.go.id` behind a reverse proxy.

**Critical configuration for HTTPS/Mixed Content issues:**

1. **TrustProxies Middleware** (`app/Http/Middleware/TrustProxies.php`):
   - Set `protected $proxies = '*';` to trust all proxies
   - This allows Laravel to detect HTTPS from `X-Forwarded-Proto` header

2. **AppServiceProvider** (`app/Providers/AppServiceProvider.php`):
   - Force HTTPS URL generation in production:
   ```php
   if (config('app.env') === 'production') {
       \URL::forceScheme('https');
       $this->app['request']->server->set('HTTPS', 'on');
   }
   ```

3. **.env Configuration**:
   - `APP_ENV=production`
   - `APP_URL=https://pasar.tangerangselatankota.go.id`
   - `APP_DEBUG=false`

**After configuration changes, always clear cache:**
```bash
php artisan optimize:clear
# Or individually:
php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear
```

## Domain Model

### Core Entities
- **Pasar** (Market): Main entity with location, area size, stall count. Related to Kelurahan/Kecamatan/Kabupaten
- **Pedagang** (Vendor): Stores vendor details with KTP, KK, SHGP documents
- **PedagangAlamat** (Vendor Address): Links vendors to specific market stalls via `PasarKategori`
- **PasarKategori** (Market Category): Represents individual stalls/sections within a market
- **Transaksi** (Transaction): Payment/rental transactions for market stalls
- **JenisLapak** (Stall Type), **JenisUsaha** (Business Type): Classification tables

### Relationships
```php
Pasar → hasMany PasarKategori
PasarKategori → hasMany PedagangAlamat
Pedagang → hasMany PedagangAlamat
```

## Code Conventions

### Validation & Response
Standard validation in `store()` and `update()` methods:
```php
$request->validate([
    'nm_pasar' => 'required|unique:tm_pasars,nm_pasar',
]);

return response()->json(['message' => 'Data ' . $this->title . ' berhasil tersimpan.']);
```

### Route Organization
Routes in `routes/web.php` use nested groups:
```php
Route::group(['middleware' => ['auth']], function () {
    Route::prefix('Master-Pasar')->namespace('MasterPasar')->name('master-pasar.')->group(function () {
        Route::resource('pasar', 'PasarController');
        Route::post('pasar/api', 'PasarController@api')->name('pasar.api');
    });
});
```

### File Uploads
Document storage in `public/images/` with fields like `foto`, `ktp`, `kk`, `shgp` in Pedagang model.

## Common Tasks

### Adding a New Resource
1. Create model in `app/Models/` with `$table` and `$fillable`
2. Create controller in appropriate namespace with `$route`, `$view`, `$title`
3. Add routes in `routes/web.php` (resource + API route)
4. Create migration if needed
5. Create views in `resources/views/pages/{module}/` following Blade layout pattern

### When Making Changes
- Always return JSON responses for AJAX operations
- Use DataTables pattern for listings (don't create custom pagination)
- Follow Indonesian naming conventions for database fields
- Respect role middleware when adding routes
- Update validation rules for both create and update (include ID in unique rules for updates)
