 <nav class="navbar navbar-expand-lg">
     <div class="container">
         <a class="navbar-brand" href="/">
             <img src="{{ site()->logo }}" alt="" />
         </a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
             aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-auto">
                 {{-- <li class="nav-item">
                     <a class="nav-link active" aria-current="page" href="electric.html">Services</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" aria-current="page" href="profile.html">How it works</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" aria-current="page" href="#">Companies</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" aria-current="page" href="#">Trade Experts</a>
                 </li> --}}
                 <li class="nav-item">
                     <a class="nav-link" aria-current="page" href="{{ route('post-job') }}">Request a quote</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" aria-current="page" href="{{ route('blogs') }}">Blogs</a>
                 </li>
                 @if (Auth::check())
                     @if (Auth::user()->role == 'user')
                         <li class="nav-item">
                             <a class="nav-link" aria-current="page" href="{{ route('user.dashboard') }}">Dashboard</a>
                         </li>
                     @endif
                     @if (Auth::user()->role == 'company')
                         <li class="nav-item">
                             <a class="nav-link" aria-current="page"
                                 href="{{ route('tasker.dashboard') }}">Dashboard</a>
                         </li>
                     @endif
                 @else
                     <li class="nav-item">
                         <a class="nav-link" aria-current="page" href="{{ route('login') }}">Sign up/Log in</a>
                     </li>
                 @endif
             </ul>
             @if (Auth::check())
                 @if (Auth::user()->role == 'user')
                     <form class="d-flex" role="search">
                         <a href={{ route('user.dashboard') }} class="btn tasker-btn" type="submit">
                             Dashboard
                         </a>
                     </form>
                 @endif
                 @if (Auth::user()->role == 'company')
                     <form class="d-flex" role="search">
                         <a href={{ route('tasker.dashboard') }} class="btn tasker-btn" type="submit">
                             Dashboard
                         </a>
                     </form>
                 @endif
             @else
                 <form class="d-flex" role="search">
                     <a href={{ route('tasker.register.step1') }} class="btn tasker-btn" type="submit">
                         Become a tasker
                     </a>
                 </form>
             @endif
             @if (Auth::check())
                 <form class="d-flex" role="search" action="{{ route('logout') }}" method="POST">
                     @csrf
                     <button class="btn btn-danger ms-2 " type="submit">
                         Logout
                     </button>
                 </form>
             @endif

         </div>
     </div>
 </nav>
