<div class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/navlogo.png') }}" alt="Logo">
    </div>
    <a href="/prof" class="{{ request()->is('/') ? 'active' : '' }}"><i class="fas fa-home"></i> Acceuille</a>
    <a href="{{ route('Encadrent') }}" class="{{ request()->routeIs('Encadrent') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i> Encadrent
    </a>
    <a href="{{ route('Rapporteur') }}" class="{{ request()->routeIs('Rapporteur') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i> Rapporteur
    </a>
    <a href="{{ route('Examinateur') }}" class="{{ request()->routeIs('Examinateur') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i> Examinateur
    </a>
    <a href="{{ route('President') }}" class="{{ request()->routeIs('President') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i> President
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
