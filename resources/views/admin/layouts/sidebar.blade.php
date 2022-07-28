<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Admin::user()->avatar }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Admin::user()->name }}</p>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.home') }}">
                    <i class="fa fa-bar-chart"></i><span>ダッシュボード(未実装)</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cog"></i>
                        <span>管理者</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('admin.adminUsers.index') }}">
                        <i class="fa fa-users"></i>
                            <span>一覧</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.adminUsers.createView') }}">
                        <i class="fa fa-user-plus"></i>
                            <span>新規作成</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-shopping-bag"></i>
                        <span>商品</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('admin.items.index') }}">
                        <i class="fa fa-shopping-bag"></i>
                            <span>一覧</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.items.createView') }}">
                        <i class="fa fa-plus"></i>
                            <span>新規作成</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-tags"></i>
                        <span>カテゴリー</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('admin.categories.index') }}">
                        <i class="fa fa-tags"></i>
                            <span>一覧</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.createView') }}">
                        <i class="fa fa-plus"></i>
                            <span>新規作成</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-building"></i>
                        <span>ブランド</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ route('admin.brands.index') }}">
                        <i class="fa fa-building"></i>
                            <span>一覧</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.brands.createView') }}">
                        <i class="fa fa-plus"></i>
                            <span>新規作成</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>