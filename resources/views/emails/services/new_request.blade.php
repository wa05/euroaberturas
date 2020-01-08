@component('mail::message')
# Introduction

Estimado {{$owner->name}}, tiene una nueva propuesta de alquiler en su cuenta NexArg por su servicio # {{$service->id}}
<br><br>
El usuario {{$user->name}} {{$user->last_name}} le envía la siguiente propuesta:
<br>
{{$rent->message }}
<hr>
Desde: {{$rent->from}}
Hasta: {{$rent->from}}

@component('mail::button', ['url' => ''])
Ver solicitudes
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
