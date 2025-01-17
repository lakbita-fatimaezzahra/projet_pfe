<div class="sidebar" style="height: 200vh;">
    <div class="logo">
        <img src="{{ asset('images/navlogo.png') }}" alt="Logo">
    </div>
    <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard*') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Acceuil
    </a>

    <a href="/etudiants" class="{{ request()->is('readst') ? 'active' : '' }}">
        <i class="fas fa-user-graduate"></i> Etudiants
    </a>
    <a href="{{ route('admin.professeur.read') }}" class="{{ request()->is('admin/professeur*') ? 'active' : '' }}">
        <i class="fas fa-chalkboard-teacher"></i> Professeurs
    </a>
    <a href="{{ route('admin.departement.index') }}" class="{{ request()->is('admin/departement*') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Départements
    </a>
    <a href="{{ route('admin.salle.index') }}" class="{{ request()->is('admin/salle*') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Salles
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
