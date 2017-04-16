<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>

        <ul class="sidebar-menu">
            @foreach($menu as $item)
                <li class="treeview">
                    <a href='javascript:;'><i class="{{ $item->description }}"></i>
                        <span>{{ $item->display_name }}</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @foreach($item->child_menu as $item_child)
                            <li><a href='{{ route("$item_child->name") }}'>{{ $item_child->display_name }}</a></li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </section>
</aside>