<div class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/navlogo.png') }}" alt="Logo">
    </div>
    <a href="/prof" class="{{ request()->is('/') ? 'active' : '' }}"><i class="fas fa-home"></i> Acceuille</a>
    {{-- <a href="/avant" class="{{ request()->is('avant') ? 'active' : '' }}"><i class="fas fa-book"></i> Avant stage</a> --}}
    <a href="/Encadrent" class="{{ request()->is('Encadrent') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Encadrent</a>
    <a href="/Rapporteur" class="{{ request()->is('Rapporteur') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Rapporteur</a>
    <a href="/Examinateur" class="{{ request()->is('Examinateur') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Examinateur</a>
    <a href="/President" class="{{ request()->is('President') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> President</a>
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
