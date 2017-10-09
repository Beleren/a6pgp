@if (Session::has('success'))
    <div class="container">
        <div class="alert alert-success alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert">X</button>
            {{ Session::get('success') }}
        </div>
    </div>
@elseif(Session::has('info'))
    <div class="container">
        <div class="alert alert-info alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert">X</button>
            {{ Session::get('info') }}
        </div>
    </div>
@elseif(Session::has('warning'))
    <div class="container">
        <div class="alert alert-warning alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert">X</button>
            {{ Session::get('warning') }}
        </div>
    </div>
@elseif(Session::has('danger'))
    <div class="container">
        <div class="alert alert-danger alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert">X</button>
            {{ Session::get('danger') }}
        </div>
    </div>
@else
@endif