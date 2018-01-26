<table class="table table-responsive" id="events-table">
    <thead>
    <th>الاسم</th>
    <th>عدد الاسأله المجابه</th>
    <th>التخصص</th>


    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{!! $user->name !!}</td>
            <td>{!! $user->answers_count !!}</td>
            <td>{!! $user->category !!}</td>
        </tr>
    @endforeach


    </tbody>
</table>
