<div class="page-content browse container-fluid">
        
        <div class="row">
            <div class="col-md-12">

                @if(isset($evaluacion))
                <div class="panel panel-bordered">
                    <div class="panel-body">

                        <div class="page-title-content">
                            <h1 class="page-title page-title-custom">
                                <i class="icon voyager-settings"></i><i class="icon fa fa-commenting-o" aria-hidden="true"></i> <div>Evaluación de {{$usuario['fullname']}}</div>
                                <div>
                                    Periodo Lectivo: {{$periodo_lectivo->nombre}}, Instrumento: {{$instrumento->nombre}}
                                </div>
                                <div>
                                    Valoración: {{$evaluacion->percentil_eva}}%
                                </div>
                                
                            </h1>
                            <div class="">
                                    <div class="select2-result-repository__avatar">
                                        <img src="{{$usuario['profileimageurl']}}">
                                    </div>
                                    <div class="select2-result-repository__meta">
                                        <div class="select2-result-repository__title">{{$usuario['fullname']}}</div>
                                        <div class="select2-result-repository__description">{{$usuario['email']}}</div>
                                    </div>
                                </div>
                        </div>
                        @if(!empty($evaluacion))
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nº</th>
                                            <th>Categoría</th>
                                            <th>Nombre Indicador</th>
                                            <th>Respuesta</th>
                                            <th>Valor de la Respuesta</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($evaluacion->respuestas_evaluacion as $respuestaIndex => $respuesta)
                                        <tr>
                                            <td>{{$respuestaIndex+1}}</td>
                                            <td>{{$respuesta->categoria->getNombre()}}</td>
                                            <td>{{$respuesta->get_indicador_nombre()}}</td>
                                            @if($respuesta->get_value_percentil() == -1) 
                                                <td>{{$respuesta->get_value_string()}}</td>
                                                <td></td>
                                            @else
                                                <td>{{$respuesta->get_value_string()}}</td>
                                                <td>{{number_format($respuesta->get_value_percentil(), 2, '.', ' ') }}% / {{$respuesta->indicador->getValorMáximoRespuesta($respuesta->getID())}}% </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alerts">
                                <div class="alert alert-info">
                                    <strong>No hay evaluaciones disponibles</strong>
                                </div>   
                            </div>
                        @endif
                                          

                    </div>
                </div>
                @endif   
                

            </div>
        </div>
    </div>