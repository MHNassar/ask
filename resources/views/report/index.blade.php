@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">التقارير</h1>

    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <!-- Id Field -->
                <div class="form-group col-lg-6">
                    {!! Form::label('id', 'عدد الاسأله:') !!}
                    <p>{{ $quesCount  }}</p>
                </div>

                <div class="form-group col-lg-6">
                    {!! Form::label('id', 'عدد الاسأله المجاب عليها:') !!}
                    <p>{{ $ansQuesCount  }}</p>
                </div>

                <div class="col-lg-6">
                    <h3 style="color: #761c19">الاقسام</h3>
                    @include('report.category')

                </div>


                <div class="col-lg-6">
                    <h3 style="color: #761c19">اعلى استشارين اجابه على الاسأله</h3>
                    @include('report.team')

                </div>
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

