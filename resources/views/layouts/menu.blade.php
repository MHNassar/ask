<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{!! route('users.index') !!}"><i class="fa fa-edit"></i><span>المستشارين</span></a>
</li>

<li class="{{ Request::is('twittes*') ? 'active' : '' }}">
    <a href="{!! route('twittes.index') !!}"><i class="fa fa-edit"></i><span>التغريدات</span></a>
</li>


