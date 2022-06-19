<div class="m-navigation mt-20">
    <nav>
        <ul>
            @if (!empty($top_bar_categories))
                @foreach ($top_bar_categories as $key => $category)
                    <li
                        class="{{ count($top_bar_categories) > 3 ? 'wp-18' : 'wp-27' }} {{ $category->breadcrumb == 'womens' ? 'active' : '' }}">
                        <a href="{{ url("/$category->breadcrumb") }}/" title="{{ url("$category->title") }}">
                            {{ $category->title }}
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </nav>
</div>
