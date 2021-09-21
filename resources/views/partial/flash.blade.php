@if(session('message'))
    <div class="col-md-12">
        <div class="alert alert-dismissible-{{session('alert-type')}}" id="session-alert">
            <button type="button" class="close" data-dismiss="alert">x</button>
            {{session('message')}}
        </div>
    </div>
@endif
