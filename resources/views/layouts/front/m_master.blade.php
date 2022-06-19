<!DOCTYPE html>
<html lang="en">
<head>
    @foreach($headSections as $section)
        @include("components/front/mobile/$section")
    @endforeach
</head>
<body>
    <header>
        @foreach($headerSections as $section)
            @include("components/front/mobile/$section")
        @endforeach
    </header>
    @foreach($topSections as $section)
        @include("components/front/mobile/$section")
    @endforeach
    @foreach($mainSections as $section)
        @include("components/front/mobile/$section")
    @endforeach
    <div class="clearfix"></div>
    <footer>
        @foreach($footerSections as $section)
            @include("components/front/mobile/$section")
        @endforeach
    </footer>
    @foreach($hiddenSections as $section)
        @include("components/front/mobile/$section")
    @endforeach
    @foreach($footSections as $section)
        @include("components/front/mobile/$section")
    @endforeach
</body>
</html>
