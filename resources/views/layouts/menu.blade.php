<li class="{{ (request()->is('dashboard')) ? 'active' : '' }}">
    <a href="{!! route('dashboard') !!}"><i class="fa fa-tachometer"></i> <span class="nav-label">Dashboard</span></a>
</li>
<li class="{{ (request()->is('client')) ? 'active' : '' }}">
    <a href="{!! route('client.index') !!}"><i class="fa fa-users"></i> <span class="nav-label">Clients</span></a>
</li>
<li class="{{ (request()->is('unit')) ? 'active' : '' }}">
    <a href="{!! route('unit.index') !!}"><i class="fa fa-dropbox"></i> <span class="nav-label">Units</span></a>
</li>
<li class="{{ (request()->is('repo*')) ? 'active' : '' }}">
    <a href="{!! route('repo.index') !!}"><i class="fa fa-recycle"></i> <span class="nav-label">Repossessed</span></a>
</li>

{{--<li class="{{ (request()->is('application')) ? 'active' : '' }}"><a href="{!! route('application.index') !!}"><i class="fa fa-list-alt"></i> <span class="nav-label">Applications</span></a></li>--}}

<li class="{{ (request()->is('application*')) ? 'active' : '' }}">
    <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Application</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="{{ (request()->is('application/status/active')) ? 'active' : '' }}"><a href="{!! route('application-status-active') !!}">{{--<i class="d-none fa fa-list-alt"></i>--}} <span class="nav-label">Current</span></a></li>
        <li class="{{ (request()->is('application/status/overdue')) ? 'active' : '' }}"><a href="{!! route('application-status-overdue') !!}">{{--<i class="d-none fa fa-list-alt"></i>--}} <span class="nav-label">Overdue</span></a></li>
        <li class="{{ (request()->is('application/status/history')) ? 'active' : '' }}"><a href="{!! route('application-status-history') !!}">{{--<i class="d-none fa fa-list-alt"></i>--}} <span class="nav-label">History</span></a></li>
    </ul>
</li>

<li class="{{ (request()->is('users')) ? 'active' : '' }}">
    <a href="{!! route('user.index') !!}"><i class="fa fa-users"></i> <span class="nav-label">Users</span></a>
</li>

<li class="{{ (request()->is('application')) ? 'active' : '' }}"><a href="{!! route('application.index') !!}"><i class="fa fa-list-alt"></i> <span class="nav-label">Collection List</span></a></li>
<li class="{{ (request()->is('application')) ? 'active' : '' }}"><a href="{!! route('application.index') !!}"><i class="fa fa-car"></i> <span class="nav-label">Collectors</span></a></li>



