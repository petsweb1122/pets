@if(!empty($pagination))
<div class="box-footer clearfix">
    <ul class="pagination pagination-sm no-margin pull-right">
        <li><a href="{{$pagination['first_link']}}" title="First Link">&laquo;&laquo;</a></li>
        @if(!empty($pagination['prev']))
        <li><a href="{{$pagination['prev']}}" title="Prev">&laquo;</a></li>
        @endif
        @foreach($pagination['pagination_links'] as $number => $data)
        <li class="{{!empty($data['class']) ? $data['class'] : ''}}"><a href="{{$data['link']}}" title="{{$number}}">{{$number}}</a></li>
        @endforeach
        @if(!empty($pagination['next']))
        <li><a href="{{$pagination['next']}}" title="Next">&raquo;</a></li>
        @endif

        <li><a href="{{$pagination['last_link']}}" title="Last Link">&raquo;&raquo;</a></li>
    </ul>
    <span class="pull-left">Page: {{$pagination['page']}} of {{$pagination['total_pages']}}</span>
</div>
@endif