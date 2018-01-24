<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'الاسم:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'البريد الالكترونى:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'الرقم السرى:') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'رقم الجوال:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Biography Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('biography', 'نبذه مختصره:') !!}
    {!! Form::textarea('biography', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('study', 'الدراسه:') !!}
    {!! Form::text('study', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('years_count', 'عدد سنين الخبره:') !!}
    {!! Form::text('years_count', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('years_count', 'التخصص:') !!}
    {!! Form::text('years_count', null, ['class' => 'form-control']) !!}
</div>
<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', 'الصوره:') !!}
    {!! Form::text('photo', null, ['class' => 'form-control']) !!}
</div>



<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('حفظ', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">الغاء</a>
</div>
