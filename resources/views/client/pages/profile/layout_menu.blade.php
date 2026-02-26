<div class="col-md-3">
    <div class="list-group">
        <a href="{{ route('client.profile.index') }}" class="list-group-item {{ request()->routeIs('client.profile.index') ? 'active' : '' }}">
            Thông tin tài khoản
        </a>
        <a href="{{ route('client.profile.orders') }}" class="list-group-item {{ request()->routeIs('client.profile.orders') ? 'active' : '' }}">
            Quản lý đơn hàng
        </a>
        <a href="{{ route('client.profile.favorite') }}" 
            class="list-group-item {{ request()->routeIs('client.profile.favorite') ? 'active' : '' }}">
                Sản phẩm yêu thích
        </a>
        <a href="{{ route('client.profile.reviews') }}" class="list-group-item {{ request()->routeIs('client.profile.reviews') ? 'active' : '' }}">
            Sản phẩm đã đánh giá
        </a>
        <a href="{{ route('auth.logout') }}" class="list-group-item text-danger">Đăng xuất</a>
    </div>
</div>