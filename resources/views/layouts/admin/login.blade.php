<!DOCTYPE html>
<html>
    <head>
        @foreach($headSections as $section)
        @include("components/admin/$section")
        @endforeach
    </head>
    <body class="hold-transition login-page">
        @foreach($mainSections as $section)
        @include("components/admin/$section")
        @endforeach

        @foreach($footSections as $section)
        @include("components/admin/$section")
        @endforeach

    </body>
</html>
