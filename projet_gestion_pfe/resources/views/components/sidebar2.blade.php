<div class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/navlogo.png') }}" alt="Logo">
    </div>
    <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard*') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Acceuille</a>

    <a href="/readst" class="{{ request()->is('readst') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Etudiant</a>
    <a href="{{ route('admin.professeur.read') }}" class="{{ request()->is('admin/professeur*') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Professeur</a>
    <a href="{{ route('admin.departement.index') }}" class="{{ request()->is('admin/departement*') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Départements</a>
    
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
