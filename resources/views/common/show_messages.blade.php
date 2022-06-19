@if(!empty(session()->get('delete_message')))
{!! session()->get('delete_message') !!}
@endif

@if(!empty(session()->get('action_message')))
{!! session()->get('action_message') !!}
@endif
