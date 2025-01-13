<div class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/PFElogo2.svg') }}" alt="Logo">
    </div>
    <a href="{{ route('responsable') }}" class="{{ request()->is('responsable/responsable') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Acceuille
    </a>
    <a href="{{ route('liststage') }}" class="{{ request()->is('responsable/liststage') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i> List stage
    </a>
    <a href="{{ route('listrapport') }}" class="{{ request()->is('responsable/listrapport') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i> List rapport
    </a>
    <a href="{{ route('deadline') }}" class="{{ request()->is('responsable/listrapport') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i> deadline
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
