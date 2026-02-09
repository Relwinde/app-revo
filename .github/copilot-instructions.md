# AI Coding Agent Instructions for REVO-LIMITED App

## Project Overview

**REVO-LIMITED** is a Laravel 10 business management system for logistics and invoicing. Built with Livewire 3 for real-time reactive components and Blade templating, it manages clients, orders (commandes), invoices (factures), proforma invoices, cash boxes (caisses), trucks (camions), drivers (chauffeurs), and suppliers (fournisseurs).

**Tech Stack:**
- Backend: Laravel 10 + PHP 8.1+
- Frontend: Livewire 3 + Blade + Vite (asset bundling)
- Database: Eloquent ORM with migrations
- Auth: Laravel Fortify + Spatie Permissions (roles-based)
- PDF Generation: mPDF for invoice printing
- UI Modal Components: wire-elements/modal

## Architecture Patterns

### 1. Livewire Component Organization

**Location:** `app/Livewire/` → domain folders → components

Components follow a **resource-centric structure** organized by domain (e.g., `Facture/`, `Client/`, `Commande/`). Each domain typically contains:
- Main list component (e.g., `Clients.php`) - extends `Component` with `WithPagination` trait
- Create/Edit components (e.g., `CreateFacture.php`)
- Modal subcomponents (e.g., `Modals/AddItem.php`) - extend `ModalComponent` from `LivewireUI\Modal`

**Key Livewire Patterns Used:**
- **Event-driven rendering**: Components emit events (`#[On('entity-created')]`) to refresh after CRUD operations
- **Pagination**: Use `WithPagination` trait for list components; paginate data with `.paginate(10)`
- **Validation**: Use Laravel's validation rules with custom French error messages
- **Modal dialogs**: Extend `ModalComponent` for forms inside modals; dispatch via `$this->dispatch('openModal'...)`
- **Property binding**: Public properties auto-bind to Blade templates via `wire:model`

Example pattern from `app/Livewire/Client/Clients.php`:
```php
class Clients extends Component {
    use WithPagination;
    public $search, $name, $email; // Auto-bound to view
    
    #[On('client-created')]
    public function render() { /* refresh logic */ }
}
```

### 2. Model-Controller Architecture (Minimal Controllers)

**Routes:** `routes/web.php` maps directly to Livewire components (not traditional controllers). Most business logic is in models or extracted into separate classes.

Example: `Route::get('/clients', Clients::class)->middleware('auth');` → loads `app/Livewire/Client/Clients.php`

**Models Location:** `app/Models/` - Use Eloquent relationships and scopes for queries:
- Models include: `User`, `Client`, `Commande`, `Facture`, `FactureProforma`, `Caisse`, `Dossier`, `BonDeCaisse`, `Chauffeur`, `Camion`, `Fournisseur`, `Marchandise`, `Depot`, `Document`
- Use `HasFactory` trait and define relationships for joins
- Use Spatie Permission traits (`HasRoles`) on `User` model for role-based access control

### 3. Database & Migrations

**Migrations Path:** `database/migrations/` - Timestamped migration files

**Key patterns:**
- Soft deletes: Many tables include `SoftDeletes` (see `2025_12_18_120400` migration)
- Timestamps: All models auto-include `created_at`, `updated_at`
- Foreign keys follow Laravel naming: `{table_singular}_id`

**Critical tables (inferred from migrations):**
- `users` - authentication + roles
- `clients`, `fournisseurs` - business entities
- `commandes` - orders from clients
- `factures`, `facture_items` - invoices
- `facture_proformas` - proforma invoices (preliminary invoicing)
- `bons_de_caisses` - cash transactions
- `dossiers` - document/case management
- `chauffeurs`, `camions` - fleet management

### 4. Authentication & Authorization

**Authentication:** Laravel Fortify (session-based) via `app/Actions/Fortify/`

**Authorization:** Spatie Laravel Permission package
- Config: `config/permission.php` - defines role/permission table mapping
- All protected routes require `->middleware('auth')`
- Check permissions in components or models using Spatie traits

**User Model:** `app/Models/User.php` extends `Authenticatable`, uses `HasRoles` trait

### 5. Blade Templating & Views

**Views Path:** `resources/views/livewire/` - Blade templates match component namespaces

**File naming convention:**
- Component: `app/Livewire/Client/Clients.php` → View: `resources/views/livewire/client/clients.blade.php`
- Modals: `app/Livewire/FactureProforma/Modals/AddItem.php` → `resources/views/livewire/facture-proforma/modals/add-item.blade.php`

**Layout:** `config/livewire.php` defines default layout as `components.layouts.app`

**Key Blade patterns:**
- Use `wire:click`, `wire:model`, `wire:submit` directives for Livewire binding
- Page structure includes header breadcrumbs and titles (passed via component `render()`)

### 6. Validation & Error Handling

**Validation approach:**
- Livewire components call `$this->validate()` with rules array
- Custom French error messages (see `AddItem.php` for example)
- Errors auto-populate `$errors` bag in view

**Example from AddItem component:**
```php
$this->validate([
    'quantity' => 'required|numeric|min:1',
], [
    'quantity.required' => 'La quantité est obligatoire.',
]);
```

## Development Workflows

### Building & Running

**Development server:**
```bash
php artisan serve
```

**Asset compilation (CSS/JS with Vite):**
```bash
npm run dev      # Watch mode
npm run build    # Production build
```

**Database setup:**
```bash
php artisan migrate          # Run pending migrations
php artisan db:seed          # Seed test data
php artisan tinker           # Interactive shell
```

### Testing

**PHPUnit configuration:** `phpunit.xml`
**Test files:** `tests/Feature/` (integration), `tests/Unit/` (unit tests)

```bash
php artisan test                    # Run all tests
php artisan test tests/Feature/...  # Run specific test
```

### Debugging & Inspection

**Laravel Tinker (REPL):**
```bash
php artisan tinker
> \App\Models\Client::first()
```

**Linting & Code Quality:**
```bash
vendor/bin/pint              # Laravel code formatter (PSR-12 standard)
vendor/bin/phpstan analyze   # Static analysis (if configured)
```

## Common Tasks & Patterns

### Adding a New CRUD Component

1. **Create model** in `app/Models/Entity.php` with relationships
2. **Create migration** in `database/migrations/`
3. **Create Livewire component** in `app/Livewire/Entity/Entity.php`
4. **Create Blade view** in `resources/views/livewire/entity/`
5. **Add route** in `routes/web.php` → `Route::get('/entities', Entity::class)->middleware('auth');`
6. **Create modal for forms** if needed (extend `ModalComponent`)

### Creating Modal Forms

```php
namespace App\Livewire\Entity\Modals;
use LivewireUI\Modal\ModalComponent;

class CreateEntity extends ModalComponent {
    public function submit() { /* validate and save */ }
}
```

**Dispatch modal from list component:**
```php
$this->dispatch('openModal', component: 'entity.modals.create-entity');
```

### PDF Generation (mPDF)

Installed package: `mpdf/mpdf` for invoice PDF export. Use in components:
```php
use Mpdf\Mpdf;
$mpdf = new Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();
```

### Permissions & Roles

Check permission in Livewire component:
```php
if (!auth()->user()->can('view_invoices')) {
    abort(403);
}
```

Or define ability in `AuthServiceProvider.php` and use policy classes.

## Project-Specific Conventions

### Naming Conventions
- **Models:** Singular, PascalCase (e.g., `Client`, `BonDeCaisse`)
- **Components:** Singular, PascalCase (e.g., `CreateFacture.php`)
- **Views:** Kebab-case matching component namespaces (e.g., `create-facture.blade.php`)
- **Routes:** Plural, lowercase (e.g., `/clients`, `/factures`)
- **Database tables:** Plural, snake_case (e.g., `bons_de_caisses`)
- **French domain terminology:** Use French names in UI/routes (clients, factures, chauffeurs) but keep code identifiers in English or mixed for clarity

### Language
- **UI/Validation messages:** French (fr) - see permission config and AddItem validation messages
- **Code comments:** Mix of English and French; prefer English for clarity
- **Config locale:** Set in `.env` (default `en` in config; update for French if needed)

### File Organization
- Domain-driven: Each business entity gets its own folder in `app/Livewire/`, `app/Models/`
- Modals nested in `Modals/` subdirectory for each domain
- Reusable components in `resources/views/components/`

## Key Files to Reference

| File | Purpose |
|------|---------|
| [routes/web.php](routes/web.php) | All route definitions (Livewire component routes) |
| [app/Models/User.php](app/Models/User.php) | Auth model with Spatie Roles trait |
| [app/Http/Kernel.php](app/Http/Kernel.php) | Middleware stack (auth, CSRF, session) |
| [config/livewire.php](config/livewire.php) | Livewire namespace & layout config |
| [config/permission.php](config/permission.php) | Spatie permission tables mapping |
| [vite.config.js](vite.config.js) | Asset bundling (CSS/JS input) |
| [composer.json](composer.json) | PHP dependencies (Laravel, Livewire, mPDF, Spatie Permission) |
| [package.json](package.json) | Node dependencies (Vite, axios) |

## Troubleshooting & Best Practices

1. **Livewire component not re-rendering?** Check `#[On('event-name')]` listeners; ensure parent dispatches event with `$this->dispatch('event-name')`
2. **Validation errors not showing?** Verify Blade template includes `@error('field')` block
3. **Database queries slow?** Use eager loading with `with()` in Eloquent; avoid N+1 queries
4. **CSS/JS not updating?** Run `npm run build` in production; use `npm run dev` in development with Vite watcher
5. **Auth middleware failing?** Ensure `->middleware('auth')` on routes and user is logged in via Fortify
6. **French messages not appearing?** Check validation message keys match localization strings in `resources/lang/`

---

**Last Updated:** February 2026 | **Framework:** Laravel 10 | **Livewire:** 3.x
