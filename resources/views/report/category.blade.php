<table class="table table-responsive" id="events-table">
    <thead>
    <th>ألقسم</th>
    <th>عدد الاسأله</th>
    <th>عدد المستشارين</th>


    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>{!! $category->name !!}</td>
            <td>{!! $category->questions->count() !!}</td>
            <td>{!! $category->users->count() !!}</td>
        </tr>
    @endforeach


    </tbody>
</table>
