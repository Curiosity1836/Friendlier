@section('navbar')
<div class="navbar" id="navbar">
    <header class="masthead mb-auto">
        <div class="inner">
            <h3 class="masthead-brand">Steam Friends</h3>
            <nav class="nav nav-masthead justify-content-center">
                <a class="nav-link active" href="{{ url('/') }}">Home</a>
                <a class="nav-link" href="{{ url('/contact') }}">Contact Me</a>
            </nav>
        </div>
    </header>
    @show
</div>
