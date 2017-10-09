@if (Session::has('success'))
    <div class="container">
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    </div>
@elseif(Session::has('info'))
    <div class="container">
        <div class="alert alert-info" role="alert">
            {{ Session::get('info') }}
        </div>
    </div>
@elseif(Session::has('warning'))
    <div class="container">
        <div class="alert alert-warning" role="alert">
            {{ Session::get('warning') }}
        </div>
    </div>
@elseif(Session::has('danger'))
    <div class="container">
        <div class="alert alert-danger" role="alert">
            {{ Session::get('danger') }}
        </div>
    </div>
@else
@endif