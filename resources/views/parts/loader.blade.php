<div id="{{$loader_id or 'loader'}}" style="display: none" class="text-center {{$loader_classes or 'padding-top-2em'}}">
    <img src="{{asset('images/loader.svg')}}" class="hide-on-small-only" alt="" style="height: 60px"/>
    <img src="{{asset('images/owl/AjaxLoader.gif')}}" class="hide-on-med-and-up" alt="" style="height: 60px"/>
    @if(empty($loader_text_off))
    <p class="text-center no-margin {{$loader_font or 'font-lg grey-text'}}">{!!$loader_text or 'Loading...'!!}</p>
    @endif
</div>
