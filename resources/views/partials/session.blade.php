@if(Session::has('fail'))
    <div class="row">
        <div class="col-md-12">
            <p class="alert alert-danger">{{ Session::get('fail') }}</p>
        </div>
    </div>
@elseif(Session::has('info'))
    <div class="row">
        <div class="col-md-12">
            <p class="alert alert-info">{{ Session::get('info') }}</p>
        </div>
    </div>
@endif
