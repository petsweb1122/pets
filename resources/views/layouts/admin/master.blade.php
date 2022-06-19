<!DOCTYPE html>
<html>
    <head>
        @foreach($headSections as $section)
        @include("components/admin/$section")
        @endforeach
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                @foreach($headerSections as $section)
                @include("components/admin/$section")
                @endforeach
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                @foreach($leftSections as $section)
                @include("components/admin/$section")
                @endforeach
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content">
                    @foreach($rightSections as $section)
                    @include("components/admin/$section")
                    @endforeach
                </section>
            </div>
            <!-- /.row (main row) -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        @foreach($footerSections as $section)
        @include("components/admin/$section")
        @endforeach
    </footer>
    @foreach($hiddenSections as $section)
    @include("components/admin/$section")
    @endforeach
@foreach($footSections as $section)
@include("components/admin/$section")
@endforeach

</body>
</html>
