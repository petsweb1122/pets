<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
@include('common.seo')

<!-- Standard iPad -->
<link rel="apple-touch-icon" sizes="72x72" href="{{url('front/img/favicon.png')}}" />
<link rel="apple-touch-icon" sizes="120x120" href="{{url('front/img/favicon.png')}}" />
<!-- Retina iPad -->
<link rel="apple-touch-icon" sizes="144x144" href="{{url('front/img/favicon.png')}}" />
<link rel="icon" sizes="144x144" href="{{url('front/img/favicon.png')}}">

<meta name="csrf-token" content="{{ csrf_token() }}">

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>


<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>

@foreach($headerCssLinks as $link)
    <link href="{{asset($link)}}" type="text/css" rel="stylesheet" media="all">
@endforeach
@foreach($headerJsLinks as $link)
    <script src="{{asset($link)}}" type="text/javascript"></script>
@endforeach

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<script>
base_url = '<?php echo url('/') ?>';
</script>
