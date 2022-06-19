<!DOCTYPE html>
<html lang="en">
<head>
    @foreach($headSections as $section)
        @include("components/front/desktop/$section")
    @endforeach
</head>
<body>
    <header>
        <div class="container-fluid">
            @foreach($headerSections as $section)
                @include("components/front/desktop/$section")
            @endforeach
        </div>
    </header>
    <div class="">
        @foreach($topSections as $section)
        @include("components/front/desktop/$section")
        @endforeach
        @foreach($mainSections as $section)
        @include("components/front/desktop/$section")
        @endforeach
    </div>
    <footer class="mt-40">
        @foreach($footerSections as $section)
        @include("components/front/desktop/$section")
        @endforeach
    </footer>
    @foreach($footSections as $section)
        @include("components/front/desktop/$section")
    @endforeach
</body>
</html>
