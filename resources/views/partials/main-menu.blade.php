<div class="js-sidebar-scroll">
    <!-- Side Navigation -->
    <div class="content-side">
        <ul class="nav-main">

            <!-- ACCUEIL -->
            <li class="nav-main-item">
                <a class="nav-main-link {{ request()->routeIs('home') ? 'active' : '' }}" href="/">
                    <i class="nav-main-link-icon si si-home"></i>
                    <span class="nav-main-link-name">Accueil</span>
                </a>
            </li>

            <!-- PARAMÈTRES -->
            <li class="nav-main-heading">Opérations</li>
            <li class="nav-main-item">
                <a class="nav-main-link {{ request()->routeIs('dossiers') ? 'active' : '' }}" href="{{ route('dossiers') }}" wire:navigate>
                    <i class="nav-main-link-icon far fa-folder"></i>
                    <span class="nav-main-link-name">Dossiers</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link {{ request()->routeIs('bon-de-caisses') ? 'active' : '' }}" href="{{ route('bon-de-caisses') }}" wire:navigate>
                    <i class="nav-main-link-icon fa fa-file-invoice-dollar"></i>
                    <span class="nav-main-link-name">Bons De Caisse</span>
                </a>
            </li>

            <li class="nav-main-item">
                <a class="nav-main-link {{ request()->routeIs('caisses') ? 'active' : '' }}" href="{{ route('caisses') }}" wire:navigate>
                    <i class="nav-main-link-icon fa fa-funnel-dollar"></i>
                    <span class="nav-main-link-name">Caisse</span>
                </a>
            </li>

            <!-- PARAMÈTRES -->
            <li class="nav-main-heading">Outils</li>

            <li class="nav-main-item">
                <a class="nav-main-link {{ request()->routeIs('clients') ? 'active' : '' }}" href="{{ route('clients') }}" wire:navigate>
                    <i class="nav-main-link-icon far fa-address-book"></i>
                    <span class="nav-main-link-name">Clients</span>
                </a>
            </li>

            <li class="nav-main-item">
                <a class="nav-main-link {{ request()->routeIs('fournisseurs') ? 'active' : '' }}" href="{{ route('fournisseurs') }}" wire:navigate>
                    <i class="nav-main-link-icon far fa-handshake"></i>
                    <span class="nav-main-link-name">Fournisseurs</span>
                </a>
            </li>

            <li class="nav-main-item">
                <a class="nav-main-link {{ request()->routeIs('camions') ? 'active' : '' }}" href="{{ route('camions') }}" wire:navigate>
                    <i class="nav-main-link-icon fa fa-truck"></i>
                    <span class="nav-main-link-name">Camions</span>
                </a>
            </li>

            <li class="nav-main-item">
                <a class="nav-main-link {{ request()->routeIs('chauffeurs') ? 'active' : '' }}" href="{{ route('chauffeurs') }}" wire:navigate>
                    <i class="nav-main-link-icon far fa-user-circle"></i>
                    <span class="nav-main-link-name">Chauffeurs</span>
                </a>
            </li>

            <li class="nav-main-item">
                <a class="nav-main-link {{ request()->routeIs('marchandises') ? 'active' : '' }}" href="{{ route('marchandises') }}" wire:navigate>
                    <i class="nav-main-link-icon fas fa-box"></i>
                    <span class="nav-main-link-name">Marchandises</span>
                </a>
            </li>


            <!-- PARAMÈTRES -->
            <li class="nav-main-heading">Paramètres</li>

            <li class="nav-main-item">
                <a class="nav-main-link {{ request()->routeIs('users') ? 'active' : '' }}"
                    href="{{ route('users') }}" wire:navigate>
                    <i class="nav-main-link-icon si si-users"></i>
                    <span class="nav-main-link-name">Utilisateurs</span>
                </a>
            </li>

            <li class="nav-main-item">
                <a class="nav-main-link {{ request()->routeIs('profils') ? 'active' : '' }}" href="{{ route('profils') }}" wire:navigate>
                    <i class="nav-main-link-icon si si-user"></i>
                    <span class="nav-main-link-name">Profiles</span>
                </a>
            </li>

        </ul>
    </div>
</div>