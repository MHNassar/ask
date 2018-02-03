@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            تعديل تغريده
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($twitte, ['route' => ['twittes.update', $twitte->id], 'method' => 'patch']) !!}

                        @include('twittes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection