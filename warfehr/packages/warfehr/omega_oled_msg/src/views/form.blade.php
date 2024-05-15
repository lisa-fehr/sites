@if (session()->has('warfehr_status'))
    <div class="alert alert-success">
        <strong>Success:</strong> {{ session()->get('warfehr_status') }}
    </div>
@endif
{!! Form::open(['method' => 'POST', 'url' => url('oled-msg')]) !!}
<p>Create a picture then send it to my Microcontroller OLED screen and 
    <a href="https://twitter.com/{{ $twitter_handle }}">Twitter</a>:</p>

@for($i = 0; $i < $rows * $columns; $i++)
    
    <div class="checkbox">
        {!! Form::checkbox('block[' . $i . ']', '1', null, ['id' => 'checkbox' . $i]) !!}
        {!! Form::label('checkbox' . $i, ' ') !!}
    </div>
    @if(($i + 1) % $columns == 0)
        <br class="clearleft">
    @endif

@endfor

<br class="clear">
{!! Form::submit('Send Picture', ['class' => 'alignright']) !!}

<div class="aligneft">
    {!! Form::text('author', '', ['placeholder' => 'Name', 'required']) !!}
</div>
{!! Form::close() !!}
<br class="clear">
