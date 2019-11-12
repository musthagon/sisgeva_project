<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="none" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="admin login">
    <title>Admin - {{ Voyager::setting("admin.title") }}</title>
    <link rel="stylesheet" href="{{ voyager_asset('css/app.css') }}">
    <!-- Favicon -->
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
    @if($admin_favicon == '')
        <link rel="shortcut icon" href="/img/LogoGENETVI_rombo.png" type="image/png">
    @else
        <link rel="shortcut icon" href="/img/LogoGENETVI_rombo.png" type="image/png">
    @endif

    <link rel="stylesheet" href="/css/voyager/login_style.css">

    <style>
        body {
            background-image:url('{{ Voyager::image( Voyager::setting("admin.bg_image"), voyager_asset("images/bg.jpg") ) }}');
            background-color: {{ Voyager::setting("admin.bg_color", "#FFFFFF" ) }};
        }
        body.login .login-sidebar {
            border-top:5px solid {{ config('voyager.primary_color','#22A7F0') }};
        }
        @media (max-width: 767px) {
            body.login .login-sidebar {
                border-top:0px !important;
                border-left:5px solid {{ config('voyager.primary_color','#22A7F0') }};
            }
        }
        body.login .form-group-default.focused{
            border-color:{{ config('voyager.primary_color','#22A7F0') }};
        }
        .login-button, .bar:before, .bar:after{
            background:{{ config('voyager.primary_color','#22A7F0') }};
        }
        .remember-me-text{
            padding:0 5px;
        }
    </style>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
</head>
<body class="login">
<div class="container-fluid">
    <div class="row">
        <div class="faded-bg animated"></div>
        <div class="hidden-xs col-sm-7 col-md-8">
            <div class="clearfix">
                <div class="col-sm-12 col-md-10 col-md-offset-2">
                    <div class="logo-title-container">
                        <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                        @if($admin_logo_img == '')
                        <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn" src="{{ voyager_asset('images/logo-icon-light.png') }}" alt="Logo Icon">
                        @else
                        <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn" src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
                        @endif
                        <div class="copy animated fadeIn">
                            <h1>{{ Voyager::setting('admin.title', 'Voyager') }}</h1>
                            <p>{{ Voyager::setting('admin.description', __('voyager::login.welcome')) }}</p>
                        </div>
                    </div> <!-- .logo-title-container -->
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">
            <div class="login-body">

                <div class="side-body padding-top">
                    <div style="background: #689df6; background-size:cover; background-image: url(http://localhost:8000/storage/settings/October2019/3CQ6DqmOi5jSyz9C3bc5.jpg); background-position: center center;position:absolute; top:0; left:0; width:100%; height:300px;"></div>
                    <div style="height:160px; display:block; width:100%"></div>
                    <div style="position:relative; z-index:9; text-align:center; margin-top: -48px;">
                        <img src="/img/LogoGENETVi.png" class="avatar" style="border-radius:50%; width:200px; height:200px;" alt="GENETVI">
                        <div class="text-muted">Aplicación Web para la Gestión de la Evaluación de Entornos Virtuales de Aprendizaje del Campus Virtual de la UCV</div>
                        <p></p>
                    </div>
                </div>



                <div class="login-container">

                    <p class="login_title">Acceder</p>

                    <form action="{{ route('login') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group form-group-default" id="emailGroup">
                            <label>Nombre de usuario</label>
                            <div class="controls">
                                <input type="text" name="cvucv_username" id="email" value="{{ old('email') }}" placeholder="Nombre de usuario" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group form-group-default" id="passwordGroup">
                            <label>Contraseña</label>
                            <div class="controls">
                                <input type="password" name="password" placeholder="Contraseña" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group" id="rememberMeGroup">
                            <div class="controls">
                                <input type="checkbox" name="remember" id="remember" value="1"><label for="remember" class="remember-me-text">Recordar</label>
                                <a class="instrucciones pull-right" href="#open_modal">
                                    <span class="voyager-question"></span>
                                    Instrucciones de acceso
                                    
                                </a>
                                <div id="open_modal" class="modal-window">
                                    <a href="#" title="Close" class="modal-close">  <span class="voyager-x"></span></a>
                                    <div class="modal-body">
                                        <a href="#" title="Close" class="modal-close2">  <span class="voyager-x"></span>Cerrar</a>
                                        <h1>Acceso</h1>
                                        <span class="tooltiptext">
                                            <div class="subcontent">
                                                Para ingresar a la Aplicación debe usar las mismas credenciales del 
                                                <a href="https://campusvirtual.ucv.ve/login/index.php" target="_blank">Campus Virtual UCV.</a>
                                            </div>
                                            <div class="subcontent">
                                                <pre><span style="color:#000080;font-family:arial, helvetica, sans-serif;"><strong>¿Posee una cuenta de correo UCV?</strong></span></pre><p style="margin-left:30px;text-align:left;"><span style="color:#000000;font-family:arial, helvetica, sans-serif;">• En el campo "Nombre de usuario" <span style="background-color:#ffff99;"><strong>escriba su usuario</strong>&nbsp;<span style="color:#000000;"><strong>sin el @ucv.ve</strong></span></span></span></p><p style="margin-left:30px;text-align:left;"><span style="color:#000000;font-family:arial, helvetica, sans-serif;">• En el campo "Contraseña" escriba la clave de su correo UCV.</span></p><p style="margin-left:30px;text-align:left;"><span style="color:#000000;font-family:arial, helvetica, sans-serif;"><span>• En caso de no poseer correo institucional, por favor diríjase a la&nbsp;Dirección&nbsp;de Tecnología de Información y Comunicaciones (DTIC), ubicada en el&nbsp;Edificio El Rectorado, PB. <strong>Debe presentar su C.I y carnet vigente.</strong></span></span></p><pre><span style="color:#000080;font-family:arial, helvetica, sans-serif;"><strong>¿Es ud. un usuario externo?</strong></span></pre><p style="margin-left:30px;text-align:left;"><span style="font-family:arial, helvetica, sans-serif;">• En el campo "Nombre de usuario" escriba su número de cédula, sin puntos ni espacios.</span></p><p style="margin-left:30px;text-align:left;"><span style="font-family:arial, helvetica, sans-serif;">• En el campo&nbsp;"Contraseña" escriba la clave suministrada por el administrador del espacio o profesor del curso.&nbsp;</span></p><pre><span style="color:#000080;font-family:arial, helvetica, sans-serif;"><strong>¿Olvidó su contraseña?</strong></span></pre><p style="text-align:left;margin-left:30px;"><span style="font-family:arial, helvetica, sans-serif;">• Usuario UCV: ingrese en&nbsp;<a target="_blank" rel="noreferrer noopener">https://recuperar_password.ucv.ve/</a></span></p><p style="text-align:left;margin-left:30px;"><span style="font-family:arial, helvetica, sans-serif;">• Usuario externo: debe dirigirse al&nbsp;administrador del espacio o profesor del curso.&nbsp;</span></p>
                                            </div>
                                        </span>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-block login-button">
                            <span class="signingin hidden"><span class="voyager-refresh"></span> Cargando...</span>
                            <span class="signin">Acceder</span>
                        </button>

                    </form>

                    <div style="clear:both"></div>

                    @if(!$errors->isEmpty())
                    <div class="alert alert-red">
                        <ul class="list-unstyled">
                            @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                </div> <!-- .login-container -->

            </div>
        </div> <!-- .login-sidebar -->
    </div> <!-- .row -->
</div> <!-- .container-fluid -->
<!-- jQuery 3 -->
<script src="/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<script>
    var btn = document.querySelector('button[type="submit"]');
    var form = document.forms[0];
    var email = document.querySelector('[name="cvucv_username"]');
    var password = document.querySelector('[name="password"]');
    btn.addEventListener('click', function(ev){
        if (form.checkValidity()) {
            btn.querySelector('.signingin').className = 'signingin';
            btn.querySelector('.signin').className = 'signin hidden';
        } else {
            ev.preventDefault();
        }
    });
    email.focus();
    document.getElementById('emailGroup').classList.add("focused");

    // Focus events for email and password fields
    email.addEventListener('focusin', function(e){
        document.getElementById('emailGroup').classList.add("focused");
    });
    email.addEventListener('focusout', function(e){
       document.getElementById('emailGroup').classList.remove("focused");
    });

    password.addEventListener('focusin', function(e){
        document.getElementById('passwordGroup').classList.add("focused");
    });
    password.addEventListener('focusout', function(e){
       document.getElementById('passwordGroup').classList.remove("focused");
    });

    /*$(window).on('click', function(event){
        if(event.target.id == 'open_modal'){
            $('#open_modal').css({display: "none"});
        }
    });*/


    // Get the modal
   /* var modal = document.getElementById("my_modal");

    // Get the button that opens the modal
    var btn = document.getElementById("open_modal");

    // Get the <span> element that closes the modal
    var span = document.getElementById("close_modal"); 

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    /*$(window).on('click', function(event){
        if(event.target.id == 'my_modal'){
            $('#my_modal').css({display: "none"});
        }
    });*/

</script>
</body>
</html>
