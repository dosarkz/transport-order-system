<ul class="nav nav-tabs">
    <li class="{{active_link("projects/$project->id")}}"><a href="/projects/{{$project->id}}?{{request()->getQueryString()}}" href="#orders" aria-expanded="true">Список заказов</a></li>
    <li class="{{active_link("projects/$project->id/registries")}}"><a  href="/projects/{{$project->id}}/registries?{{request()->getQueryString()}}" aria-expanded="true">Общий реестр</a></li>
    @if(auth()->user()->hasRole('admin'))
        <li class="{{active_link("projects/$project->id/services")}}"><a  href="/projects/{{$project->id}}/services" aria-expanded="true">Услуги</a></li>
    @endif
    <li class="{{active_link("projects/$project->id/contractors")}}"><a  href="/projects/{{$project->id}}/contractors">Контрагенты</a></li>
    <li ><a data-toggle="tab" href="#totallwork" aria-expanded="false">Акт вып. работ</a></li>
    <li ><a data-toggle="tab" href="#vedomost" aria-expanded="false">Ведомость</a></li>
    @if(auth()->user()->hasRole('admin'))
        <li class="{{active_link("projects/$project->id/accounts")}}"><a href="/projects/{{$project->id}}/accounts" aria-expanded="false">Учетные записи</a></li>
    @endif
</ul>