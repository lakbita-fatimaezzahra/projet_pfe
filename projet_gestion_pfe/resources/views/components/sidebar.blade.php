<div class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/PFElogo2.svg') }}" alt="Logo">
    </div>
    <a href="/student" class="{{ request()->is('/') ? 'active' : '' }}"><i class="fas fa-home"></i> Acceuille</a>
    {{-- <a href="/avant" class="{{ request()->is('avant') ? 'active' : '' }}"><i class="fas fa-book"></i> Avant stage</a> --}}

    <a href="javascript:void(0)" class="{{ request()->is('stage') || request()->is('avant') || request()->is('apres') ? 'active' : '' }}" onclick="toggleStageOptions()">
        <i class="fas fa-book"></i>
        Stage
    </a>

    <div id="stage-options" style="display:none;">
        <a href="/stage" class="{{ request()->is('stage') ? 'active' : '' }}"> infoStage</a>
        <a href="{{route('avantStage')}}" class="{{ request()->is('avant') ? 'active' : '' }}">Avant stage</a>
        <a href="/apres" class="{{ request()->is('apres') ? 'active' : '' }}">Après stage</a>
       
    </div>

    <a href="/rapport" class="{{ request()->is('rapport') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Rapport</a>
    
    
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
