<!--div class="shop-icons">
    <ul class="desktop-category">
        @foreach ($categories as $category)
            <li class="rounded">
                <a href="{{$category['breadcrumb']}}" title="{{$category['title']}}">
                     <img alt="Category Image" class=" bg-white rounded-circle" src="{{url('category/'.$category['dir'].'/'.$category['image'].'')}}">
                    <br>{{$category['title']}}
                </a>
            </li>
        @endforeach
    </ul>
</div-->


<div class="shop-icons">
    <ul class="desktop-category">
        <li class="rounded">
            <a title="Dog" href="{{url('/dog')}}" class="">
                 <img alt="Dog" class=" bg-white rounded-circle" src="{{url('front/img/category-img/dog.png')}}">
                <br>Dog
            </a>
        </li>
        <li class="rounded">
            <a title="Cat" href="{{url('/cat')}}" class="">
                 <img alt="Cat" class=" bg-white rounded-circle" src="{{url('front/img/category-img/cat.png')}}">
                <br>Cat
            </a>
        </li>
        <li class="rounded">
            <a title="Bird" href="{{url('/domestic-bird')}}" class="">
                 <img alt="Bird" class=" bg-white rounded-circle" src="{{url('front/img/category-img/bird.png')}}">
                <br>Bird
            </a>
        </li>
        <li class="rounded">
            <a title="Fish" href="{{url('/aquatic')}}" class="">
                 <img alt="Fish" class=" bg-white rounded-circle" src="{{url('front/img/category-img/fish.png')}}">
                <br>Fish
            </a>
        </li>
        <li class="rounded">
            <a title="Reptile" href="{{url('/reptile')}}" class="">
                 <img alt="Reptile" class=" bg-white rounded-circle"
                src="{{url('front/img/category-img/reptile.png')}}">
                <br>Reptile
            </a>
        </li>
        <li class="rounded">
            <a title="Small Animals" href="{{url('/small-animal')}}" class="">
                 <img alt="Small Animals" class=" bg-white rounded-circle" src="{{url('front/img/category-img/s-a.png')}}">
                <br>Small Animals
            </a>
        </li>
        <li class="rounded">
            <a title="Farm Animals" href="{{url('/large-animal-livestock')}}" class="">
                 <img alt="Farm Animals" class=" bg-white rounded-circle" src="{{url('front/img/category-img/f-a.png')}}">
                <br>Farm Animals
            </a>
        </li>
    </ul>
</div>
