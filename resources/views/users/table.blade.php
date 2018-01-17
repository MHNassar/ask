<table class="table table-responsive" id="events-table">
    <thead>
    <th>الإسم</th>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{!! $user->name !!}</td>
        </tr>
    @endforeach

    </tbody>
</table>
