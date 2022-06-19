<div class="mobile-categories-panel">
    <div class="top-nav">
        <ul>
            <li class="left"><a title="categories" href="#">Categories</a></li>
        </ul>
    </div>
    <div class="clearfix"></div>
    <div class="bottom-nav">
        <!-- HEADER SLIDER-->
        <div class="category-filter filter-form">
            <div class="sidenav">
                <ul>
                    @foreach ($left_cat_navigations as $cat_nav)
                        <li><a title="{{ $cat_nav['title'] }}" href='{{ $cat_nav['link'] }}'>{{ $cat_nav['title'] }}</a>
                            @if (!empty($cat_nav['childs']))
                                <ul class="submenu">
                                    @foreach ($cat_nav['childs'] as $child1)
                                        <li><a title="{{ $child1['title'] }}" href='{{ $child1['link'] }}'>{{ $child1['title'] }}</a>
                                            <ul class="submenu">
                                                @foreach ($child1['childs'] as $child2)
                                                    <li><a title="{{ $child2['title'] }}" href='{{ $child2['link'] }}'>{{ $child2['title'] }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
            <script>
                $('.submenu').hide();

                $('.submenu').parents("li").prepend("<span class='glyphicon'>+</span>");

                $('.glyphicon').click(function() {
                    $(this).closest('li').find('ul.submenu').first().slideToggle("slow");
                });
            </script>
        </div>
    </div>
    <span class="close-navigation-panel">X</span>
</div>
<div class="wrap-panel-navigation"></div>
