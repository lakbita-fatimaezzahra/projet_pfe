<div class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/PFElogo2.svg') }}" alt="Logo">
    </div>
    <a href="/prof" class="{{ request()->is('/') ? 'active' : '' }}"><i class="fas fa-home"></i> Acceuille</a>
    <a href="{{ route('ListStageEncadrent') }}" class="{{ request()->routeIs('ListStageEncadrent') ? 'active' : '' }}">
    <i class="fas fa-user-tie"></i> Encadrent
    </a>
    <a href="{{ route('ListStageRapport') }}" class="{{ request()->routeIs('ListStageRapport') ? 'active' : '' }}">
    <i class="fas fa-file-alt"></i> Rapporteur
    </a>
    <a href="{{ route('ListStageExaminateur') }}" class="{{ request()->routeIs('ListStageExaminateur') ? 'active' : '' }}">
    <i class="fas fa-chalkboard-teacher"></i> Examinateur
    </a>
    <a href="{{ route('ListStagePresident') }}" class="{{ request()->routeIs('ListStagePresident') ? 'active' : '' }}">
    <i class="fas fa-user-shield"></i> President
    </a>
    
</div>

<script>
    function toggleStageOptions() {
        const options = document.getElementById('stage-options');
        if (options.style.display === "none") {
            options.style.display = "block";
        } else {
            options.style.display = "none";
        }
    }
</script>
