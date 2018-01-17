<table class="table table-responsive" id="twittes-table">
    <thead>
        <tr>
            <th>Body</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($twittes as $twitte)
        <tr>
            <td>{!! $twitte->body !!}</td>
            <td>
                {!! Form::open(['route' => ['twittes.destroy', $twitte->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('twittes.show', [$twitte->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('twittes.edit', [$twitte->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>