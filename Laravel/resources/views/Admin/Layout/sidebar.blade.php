<nav>


	<ul>

		@canany('Store View','Store Settings View')
		<li>
			<a href="#" title="Store"><i class="fa fa-lg fa-fw fas fa-shopping-cart"></i> <span class="menu-item-parent">Store</span></a>

			<ul>
				@can('Store View')
				<li class="{{ Route::current()->getName() == 'admin.store.index' ? "active" : "" }}">
					<a href="{{ route('admin.store.index') }}" title="Store"><span class="menu-item-parent">Store</span></a>
				</li>
				@endcan
				<li class="{{ Route::current()->getName() == 'admin.cpcstore.index' ? "active" : "" }}">
					<a href="{{ route('admin.cpcstore.index') }}" title="CPC Store"><span class="menu-item-parent">CPC Store</span></a>
				</li>
				@can('Store Settings View')
				<li class="{{ Route::current()->getName() == 'admin.storesetting.index' ? "active" : "" }}">
					<a href="{{ route('admin.storesetting.index') }}" title="Store Settings"><span class="menu-item-parent">Store Settings</span></a>
				</li>
				@endcan
			</ul>


		</li>
		@endcanany
		@canany(['Category View'])
		<li class="">
			<a href="#" title="Category"><i class="fa fa-lg fa-fw fas fa-area-chart"></i> <span class="menu-item-parent">Category</span></a>

			<ul>
				@can('Category View')
				<li class="{{ Route::current()->getName() == 'admin.category.index' ? "active" : "" }}">
					<a href="{{ route('admin.category.index') }}" title="Category"><span class="menu-item-parent">Category</span></a>
				</li>
				@endcan
				@can('Category Settings View')
				<li class="{{ Route::current()->getName() == 'admin.categorysetting.index' ? "active" : "" }}">
					<a href="{{ route('admin.categorysetting.index') }}" title="Category Settings"><span class="menu-item-parent">Category Settings</span></a>
				</li>
				@endcan
			</ul>

		</li>
		@endcanany
		<li class="">
			<a href="#" title="Social Media"><i class="fa fa-lg fa-fw fas fa-facebook-square"></i> <span class="menu-item-parent">Social Media</span></a>

			<ul>
				<li class="{{ Route::current()->getName() == 'admin.socialmedia.index' ? "active" : "" }}">
					<a href="{{ route('admin.socialmedia.index') }}" title="Post Links"><span class="menu-item-parent">Post Links</span></a>
				</li>
			</ul>

		</li>
		@canany(['Coupon View', 'Coupon Rank','Submitted Coupon View'])
		<li class="">
			<a href="#" title="Coupon"><i class="fa fa-lg fa-fw fas fa-tag"></i> <span class="menu-item-parent">Coupon</span></a>
			<ul>
				@can('Coupon View')
				<li class="{{ Route::current()->getName() == 'admin.coupon.index' ? "active" : "" }}">
					<a href="{{ route('admin.coupon.index') }}" title="Coupon"><span class="menu-item-parent">Coupon</span></a>
				</li>
				@endcan
				@can('Submitted Coupon View')
				<li class="{{ Route::current()->getName() == 'admin.submittedcoupon.index' ? "active" : "" }}">
					<a href="{{ route('admin.submittedcoupon.index') }}" title="Submitted Coupon"><span class="menu-item-parent">Submitted Coupon</span></a>
				</li>
				@endcan
				@can('Coupon Rank')
				<li class="{{ Route::current()->getName() == 'admin.coupon.couponrank' ? "active" : "" }}">
					<a href="{{ route('admin.coupon.couponrank') }}" title="Rank Coupon"><span class="menu-item-parent">Rank Coupon</span></a>
				</li>
				@endcan
				<li class="{{ Route::current()->getName() == 'admin.coupon.globaloffers' ? "active" : "" }}">
					<a href="{{ route('admin.coupon.globaloffers') }}" title="Global Offers"><span class="menu-item-parent">Global Offers</span></a>
				</li>
			</ul>
		</li>
		@endcanany
		@canany(['Home Settings View', 'Home Banner View','Home Coupon/Deals View'])
		<li class="">
			<a href="#" title="Home"><i class="fa fa-lg fa-fw fas fa-home"></i> <span class="menu-item-parent">Home</span></a>
			<ul>
				@can('Home Settings View')
				<li class="{{ Route::current()->getName() == 'admin.homesetting.index' ? "active" : "" }}">
					<a href="{{ route('admin.homesetting.index') }}" title="Home Settings"><span class="menu-item-parent">Home Settings</span></a>
				</li>
				@endcan
				@can('Home Banner View')
				<li class="{{ Route::current()->getName() == 'admin.coupon.homebanner' ? "active" : "" }}">
					<a href="{{ route('admin.coupon.homebanner') }}" title="Home Banner"><span class="menu-item-parent">Home Banner</span></a>
				</li>
				@endcan
				@can('Home Coupon/Deals View')
				<li class="{{ Route::current()->getName() == 'admin.coupon.homecoupon' ? "active" : "" }}">
					<a href="{{ route('admin.coupon.homecoupon') }}" title="Home Coupon/Deals"><span class="menu-item-parent">Home Coupon/Deals</span></a>
				</li>
				@endcan
				<li class="{{ Route::current()->getName() == 'admin.homesetting.couponrank' ? "active" : "" }}">
					<a href="{{ route('admin.homesetting.couponrank') }}" title="Rank Home Coupons"><span class="menu-item-parent">Rank Home Coupons</span></a>
				</li>
			</ul>
		</li>
		@endcanany
		@canany(['SpecialPage View'])
		<li class="">
			<a href="#" title="Special Page"><i class="fa fa-lg fa-fw fas fa-calendar"></i><span class="menu-item-parent">Special Event Page</span></a>
			<ul>
				@can(['SpecialPage View'])
				<li class="{{ Route::current()->getName() == 'admin.specialpage.index' ? "active" : "" }}">
					<a href="{{ route('admin.specialpage.index') }}" title="Special Page"><span class="menu-item-parent">Special Page</span></a>
				</li>
				<li class="{{ Route::current()->getName() == 'admin.specialpage.couponrank' ? "active" : "" }}">
					<a href="{{ route('admin.specialpage.couponrank') }}" title="Special Page Coupon Rank"><span class="menu-item-parent">Special Page Coupon Rank</span></a>
				</li>
				@endcan
			</ul>
		</li>
		@endcanany
		@canany(['Site Info View'])
		<li class="">
			<a href="#" title="Site Info"><i class="fa fa-lg fa-fw fas fa-info"></i><span class="menu-item-parent">Site Info</span></a>
			<ul>
				@can(['Site Info View'])
				<li class="{{ Route::current()->getName() == 'admin.siteinfo.index' ? "active" : "" }}">
					<a href="{{ route('admin.siteinfo.index') }}" title="Site Info"><span class="menu-item-parent">Site Info</span></a>
				</li>
				@endcan
			</ul>
		</li>
		@endcanany
		@canany(['Subscribed Users', 'User Messages'])
		<li class="">
			<a href="#" title="Site Info"><i class="fa fa-lg fa-fw fas fa-envelope"></i><span class="menu-item-parent">Subscribed</span></a>
			<ul>
				@can(['Subscribed Users'])
				<li class="{{ Route::current()->getName() == 'admin.subscribe.index' ? "active" : "" }}">
					<a href="{{ route('admin.subscribe.index') }}" title="Subscribed Users"><span class="menu-item-parent">Subscribed Users</span></a>
				</li>
				@endcan
				@can(['User Messages'])
				<li class="{{ Route::current()->getName() == 'admin.usermessage.index' ? "active" : "" }}">
					<a href="{{ route('admin.usermessage.index') }}" title="User Messages"><span class="menu-item-parent">User Messages</span></a>
				</li>
				@endcan
			</ul>
		</li>
		@endcanany
		@canany(['User View', 'Role View','User Coupon View'])
		<li class="">
			<a href="#" title="Site Info"><i class="fa fa-lg fa-fw fas fa-user"></i><span class="menu-item-parent">User Management</span></a>
			<ul>
				@can(['User View'])
				<li class="{{ Route::current()->getName() == 'admin.user.index' ? "active" : "" }}">
					<a href="{{ route('admin.user.index') }}" title="User"><span class="menu-item-parent">User</span></a>
				</li>
				@endcan
				@can(['Role View'])
				<li class="{{ Route::current()->getName() == 'admin.role.index' ? "active" : "" }}">
					<a href="{{ route('admin.role.index') }}" title="Role"><span class="menu-item-parent">Role</span></a>
				</li>
				@endcan
				@can(['User Coupon View'])
				<li class="{{ Route::current()->getName() == 'admin.usercoupon.index' ? "active" : "" }}">
					<a href="{{ route('admin.usercoupon.index') }}" title="User Coupon"><span class="menu-item-parent">User Coupon</span></a>
				</li>
				@endcan
			</ul>
		</li>
		@endcanany
		@canany(['Visitor View', 'VisitorIPExclude View'])
		<li class="">
			<a href="#" title="Site Info"><i class="fa fa-lg fa-fw fas fa-users"></i><span class="menu-item-parent">Traffic Analysis</span></a>
			<ul>
				@can(['Visitor View'])
				<li class="{{ Route::current()->getName() == 'admin.visitor.index' ? "active" : "" }}">
					<a href="{{ route('admin.visitor.index') }}" title="Visitor"><span class="menu-item-parent">Store Visitor</span></a>
				</li>
				<li class="{{ Route::current()->getName() == 'admin.visitor.coupon' ? "active" : "" }}">
					<a href="{{ route('admin.visitor.coupon') }}" title="Visitor"><span class="menu-item-parent">Coupon Visitor</span></a>
				</li>
				@endcan
				@can(['VisitorIPExclude View'])
				<li class="{{ Route::current()->getName() == 'admin.excludetrafficip.index' ? "active" : "" }}">
					<a href="{{ route('admin.excludetrafficip.index') }}" title="Visitor IP Exclude"><span class="menu-item-parent">Visitor IP Exclude</span></a>
				</li>
				@endcan
				@can(['Visitor View'])
				<li class="{{ Route::current()->getName() == 'admin.storevisitoranalysis.index' ? "active" : "" }}">
					<a href="{{ route('admin.storevisitoranalysis.index') }}" title="Store Visitors Count"><span class="menu-item-parent">Store Visitors Count</span></a>
				</li>
				@endcan
			</ul>
		</li>
		@endcanany



	</ul>
</nav>