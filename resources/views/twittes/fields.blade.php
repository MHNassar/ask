<!-- Body Field -->
<div class="form-group col-sm-12">
    {!! Form::label('body', 'التغريده:') !!}
    {!! Form::textarea('body', null, ['class' => 'form-control']) !!}

</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('حفظ', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('twittes.index') !!}" class="btn btn-default">إلغاء</a>
</div>
