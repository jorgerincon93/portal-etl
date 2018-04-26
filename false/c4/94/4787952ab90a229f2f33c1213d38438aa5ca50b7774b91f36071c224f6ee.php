<?php

/* plantillaLogueo.html */
class __TwigTemplate_c4944787952ab90a229f2f33c1213d38438aa5ca50b7774b91f36071c224f6ee extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"es\">
  
<head>
    <meta charset=\"utf-8\">

    <title>ETL SOLUCIONES  S.A.S</title>

    <!-- Estilos Generales del aplicativo -->

\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\">
    <meta name=\"apple-mobile-web-app-capable\" content=\"yes\"> 
    
\t<!--<link href=\"css/bootstrap.min.css\" rel=\"stylesheet\" type=\"text/css\" />
\t<link href=\"css/bootstrap-responsive.min.css\" rel=\"stylesheet\" type=\"text/css\" />

\t<link href=\"css/font-awesome.css\" rel=\"stylesheet\">
    <link href=\"http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600\" rel=\"stylesheet\">
    
\t<link href=\"css/style.css\" rel=\"stylesheet\" type=\"text/css\">-->
\t<link href=\"css/signin.css\" rel=\"stylesheet\" type=\"text/css\">
    
\t<link rel=\"shortcut icon\" href=\"mlp.ico\">
    <!-- Posibilita usar Jquery -->
\t<script type=\"text/javascript\" src=\"js/jquery/jquery-3.2.1.min.js\"></script>
    <script type=\"text/javascript\" src=\"libraries/javascript/jquery.js\"></script>

    

    <!-- Validadores campos de formulario del aplicativo-->

    <script src=\"libraries/javascript/validacion/jquery.validate.js\" type=\"text/javascript\"></script>

    

</head>

<body> 

\t<form name=\"envio_datos\" id=\"envio_datos\" method=\"post\" action=\"javascript:EnviarFormulario()\">
\t\t<div class=\"form\">
  \t\t\t<div class=\"forceColor\"></div>
  \t\t\t  <div class=\"topbar\">
    \t\t\t<div class=\"spanColor\"></div>
    \t\t\t  <input type=\"text\" id=\"usuario\" name=\"usuario\" value=\"\" placeholder=\"Usuario\"  class=\"input\"  />
    \t\t\t  <input type=\"password\" id=\"clave\" name=\"clave\" value=\"\" placeholder=\"Contraseña\" class=\"input\"/>
    \t\t      <div id=\"error_ingreso\"></div>
  \t\t\t  </div>
  \t \t\t\t<button class=\"submit\" id=\"submit\">Login</button>
  \t \t\t\t
         </div>

\t    <input type=\"hidden\" name=\"component\" id=\"component\" value=\"AccederSistema\" />

        <input type=\"hidden\" name=\"method\" id=\"method\" value=\"validarLogueoUsuario\" />

    </form>

</body>

<script>

\t\$(document).ready(function(){
            // \$(\"#envio_datos\").validate();
\t    \$(document).ajaxStart(function(){

\t        \$('#imgCargando').css('visibility','visible');

\t    })

\t    .ajaxStop(function() {

\t        \$('#imgCargando').css('visibility','hidden');

\t    });

\t});

\t
\tfunction EnviarFormulario(){
\t\t
\t\t\$.ajax({

\t        url: \"index_blank.php\",
\t        type: 'POST',
\t        data:\$('#envio_datos').serialize(),
\t        success:function(msm){
\t        \tconsole.log(msm);
\t            switch(msm){

\t                case 'faltante':

\t                    \$('#error_ingreso').html(\" * Debe ingresar usuario y clave para continuar.\");

\t                    break;

\t                case 'error':

\t                    \$('#error_ingreso').html(\" * Error de acceso, por favor verifique sus datos.\");

\t                    break;

                        case 'inactivo':

\t                    \$('#error_ingreso').html(\" * El usuario esta inactivo, contacte al Administrador del sistema.\");

\t                    break;    

\t                case 'logueado':

                            direccionarLogueado();

\t                    break;

\t                default : 

\t                \t\$('#error_ingreso').html(msm);

\t            \t\tbreak;

\t            }

\t        }

\t    });

\t}

\t

\tfunction direccionarLogueado(){

\t\twindow.location = \"\";

\t}

</script>


<script src=\"libraries/javascript/diseno/jquery-1.7.2.min.js\"></script>
<script src=\"libraries/javascript/diseno/bootstrap.js\"></script>

<script src=\"libraries/javascript/diseno/signin.js\"></script>
</html>";
    }

    public function getTemplateName()
    {
        return "plantillaLogueo.html";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
