<div class="js-sidebar-scroll">
    <!-- Side Navigation -->
    <div class="content-side">
        <ul class="nav-main">

            <!-- ACCUEIL -->
            <li class="nav-main-item">
                <a class="nav-main-link" href="#">
                    <i class="nav-main-link-icon si si-home"></i>
                    <span class="nav-main-link-name">Accueil</span>
                </a>
            </li>


            <!-- PARAMÈTRES -->
            <li class="nav-main-heading">Paramètres</li>

            <li class="nav-main-item">
                <a class="nav-main-link {{ request()->routeIs('utilisateurs') ? 'active' : '' }}"
                    href="{{ route('utilisateurs') }}" wire:navigate>
                    <i class="nav-main-link-icon si si-users"></i>
                    <span class="nav-main-link-name">Utilisateurs</span>
                </a>
            </li>

            <li class="nav-main-item">
                <a class="nav-main-link" href="#">
                    <i class="nav-main-link-icon si si-user"></i>
                    <span class="nav-main-link-name">Profils</span>
                </a>
            </li>

        </ul>
    </div>
</div>