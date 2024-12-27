<div class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/navlogo.png') }}" alt="Logo">
    </div>
    <a href="affectations" class="{{ request()->is('responsable/index') ? 'active' : '' }}"><i class="fas fa-home"></i> Acceuille</a>
    <a href="assign-role" class="{{ request()->is('responsable/asign') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> affectations</a>
    <a href="remove-role" class="{{ request()->is('responsable/remove') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> supprimer</a>
    <a href="professor-stages/{profId}/{role}" class="{{ request()->is('responsable/prof_stage') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Professeur</a>
    <a href="stage-assignments/{stageId}" class="{{ request()->is('responsable/affect_stage') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> affectation stage</a>
    <a href="update-role" class="{{ request()->is('responsable/update') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> mise ajour</a>

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
