<table class="table table-responsive" id="events-table">
    <thead>
    <th>الإسم</th>
    <th>البريد الالكترونى</th>
    <th>رقم الجوال</th>
    <th>الدراسه</th>
    <th>عدد سنين الخبره</th>
    <th colspan="3"></th>

    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{!! $user->name !!}</td>
            <td>{!! $user->email !!}</td>
            <td>{!! $user->phone !!}</td>
            <td>{!! $user->study !!}</td>
            <td>{!! $user->years_count !!}</td>
            <td>
                {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                <div class='btn-group'>

                    <a href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
