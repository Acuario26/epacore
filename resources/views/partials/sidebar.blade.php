@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
 <ul class="sidebar-menu">
		  <li class="header">Sistema Integrado</li>
			@foreach ($menus as $key => $item)
								@if ($item['parent'] != 0)
									@break
								@endif
								@include('partials.menu-item', ['item' => $item])
			@endforeach

        </ul>
    </section>
</aside>

