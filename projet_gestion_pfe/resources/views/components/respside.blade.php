<div class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/navlogo.png') }}" alt="Logo">
    </div>
    <a href="responsable" class="{{ request()->is('responsable/responsable') ? 'active' : '' }}"><i class="fas fa-home"></i> Acceuille</a>
    <a href="liststage" class="{{ request()->is('responsable/liststage') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> List stage</a>
   

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
