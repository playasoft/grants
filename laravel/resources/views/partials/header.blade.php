<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="hamburger pull-right visible-xs">
            <span class="glyphicon glyphicon-menu-hamburger"></span>
        </div>

        <div class="navbar-header">
            <a class="navbar-brand" href="/">Weightlifter</a>
        </div>

        <div class="collapse navbar-collapse"> 
            <ul class="nav navbar-nav">
                <li><a href="/about">About</a></li>
                
                @if(Auth::check() && Auth::user()->role == 'admin')
                    <li><a href="/questions">Questions</a></li>
                    <li><a href="/users">Users</a></li>
                    <li><a href="/applications">Uploads</a></li>
                @endif
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    <li><a href="/logout">Logout</a></li>
                @else
                    <li><a href="/login">Login</a></li>
                    <li><a href="/register">Register</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
