<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ _('API') }}</a>
            <a href="#" class="simple-text logo-normal">{{ _('Teste Dev PHP') }}</a>
        </div>
        <ul class="nav">
            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ _('Dashboard') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'Configuração') class="active " @endif>
                <a href="{{ route('config.index') }}">
                    <i class="tim-icons icon-badge"></i>
                    <p>{{ _('Configuração Api') }}</p>
                </a>
            </li>

            <li @if ($pageSlug == 'categ') class="active " @endif>
                <a href="{{ route('categorias.index') }}">
                    <i class="tim-icons icon-badge"></i>
                    <p>{{ _('Categorias') }}</p>
                </a>
            </li>

        </ul>
    </div>
</div>
