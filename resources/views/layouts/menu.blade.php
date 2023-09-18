<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('dashboard.index') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>ড্যাশবোর্ড</p>
    </a>
</li>

@if(Auth::user()->role == 'admin')
<li class="nav-item">
    <a href="{{ route('dashboard.users') }}" class="nav-link {{ Request::is('dashboard/users') ? 'active' : '' }} {{ Request::is('dashboard/users/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>ব্যবহারকারীগণ</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin')
<li class="nav-item">
    <a href="{{ route('dashboard.payments') }}" class="nav-link {{ Request::is('dashboard/payments') ? 'active' : '' }} {{ Request::is('dashboard/payments/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-hand-holding-usd"></i>
        <p>পেমেন্টসমূহ</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin')
<li class="nav-item">
    <a href="{{ route('dashboard.packages') }}" class="nav-link {{ Request::is('dashboard/packages') ? 'active' : '' }} {{ Request::is('dashboard/packages/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-coins"></i>
        <p>প্যাকেজ</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
<li class="nav-item">
    <a href="{{ route('dashboard.questions') }}" class="nav-link {{ Request::is('dashboard/questions') ? 'active' : '' }} {{ Request::is('dashboard/questions/*') ? 'active' : '' }}">
        <i class="nav-icon far fa-folder-open"></i>
        <p>প্রশ্নব্যাংক</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
<li class="nav-item">
    <a href="{{ route('dashboard.exams') }}" class="nav-link {{ Request::is('dashboard/exams') ? 'active' : '' }} {{ Request::is('dashboard/exams/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tasks"></i>
        <p>পরীক্ষাসমূহ</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
<li class="nav-item">
    <a href="{{ route('dashboard.courses') }}" class="nav-link {{ Request::is('dashboard/courses') ? 'active' : '' }} {{ Request::is('dashboard/courses/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-layer-group"></i>
        <p>কোর্সসমূহ</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager' || Auth::user()->role == 'volunteer')
<li class="nav-item">
    <a href="{{ route('dashboard.questions.reported') }}" class="nav-link {{ Request::is('dashboard/reported') ? 'active' : '' }} {{ Request::is('dashboard/reported/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-flag"></i>
        <p>রিপোর্টেড প্রশ্নসমূহ</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('dashboard.questions.changetopic') }}" class="nav-link {{ Request::is('dashboard/change/topic/questions') ? 'active' : '' }} {{ Request::is('dashboard/change/topic/questions/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-bookmark"></i>
        <p>টপিক পরিবর্তন</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
<li class="nav-item">
    <a href="{{ route('dashboard.materials') }}" class="nav-link {{ Request::is('dashboard/materials') ? 'active' : '' }} {{ Request::is('dashboard/materials/*') ? 'active' : '' }}">
        <i class="nav-icon far fa-file-alt"></i>
        <p>ম্যাটেরিয়ালসমূহ</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin')
<li class="nav-item">
    <a href="{{ route('dashboard.messages') }}" class="nav-link {{ Request::is('dashboard/messages') ? 'active' : '' }} {{ Request::is('dashboard/messages/*') ? 'active' : '' }}">
        <i class="nav-icon far fa-envelope"></i>
        <p>
            মেসেজসমূহ
            @if($unresolvedmessagecount > 0)
            ({{ $unresolvedmessagecount }})
            @endif
        </p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin')
<li class="nav-item">
    <a href="{{ route('dashboard.notifications') }}" class="nav-link {{ Request::is('dashboard/notifications') ? 'active' : '' }} {{ Request::is('dashboard/notification/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-bell"></i>
        <p>নোটিফিকেশন</p>
    </a>
</li>
@endif

@if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
<li class="nav-item">
    <a href="{{ route('dashboard.blogs') }}" class="nav-link {{ Request::is('dashboard/blogs') ? 'active' : '' }} {{ Request::is('dashboard/blogs/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-pen-nib"></i>
        <p>ব্লগ</p>
    </a>
</li>
@endif

{{-- <li class="nav-item">
    <a href="{{ route('dashboard.components') }}" class="nav-link {{ Request::is('dashboard/components') ? 'active' : '' }}">
        <i class="nav-icon fas fa-laptop-code"></i>
        <p>Components</p>
    </a>
</li> --}}
<li class="nav-item">
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>লগআউট</p>
    </a>
</li>
