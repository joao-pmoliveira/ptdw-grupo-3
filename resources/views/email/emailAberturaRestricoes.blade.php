<div>
    <!-- Because you are alive, everything is possible. - Thich Nhat Hanh -->
    <p>&emsp;Caro(a) docente {{$docente}},</p>
    <p>&emsp;Já se encontra disponível os formulários de impedimentos de horários{{$withUcs}} referente ao ano lectivo {{$ano}}/{{$anoProximo}} e {{$semestre}}º semestre.</p>
    <br>
    <p>&emsp;Para preencher as suas restrições diriga-se à plataforma de {{$appName}}, na página <a href={{$link}}>Preencher restrições</a>.</p>
    <br>
    <div>
        {{$ucsRespList()}}
        {{ $ucsList()}}
    </div>
</div>
