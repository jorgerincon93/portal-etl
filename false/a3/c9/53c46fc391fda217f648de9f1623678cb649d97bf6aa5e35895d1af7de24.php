<?php

/* agregarNomina.html */
class __TwigTemplate_a3c953c46fc391fda217f648de9f1623678cb649d97bf6aa5e35895d1af7de24 extends Twig_Template
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
        echo twig_escape_filter($this->env, (isset($context["COMODIN"]) ? $context["COMODIN"] : null), "html", null, true);
        echo "

<!-- Modal -->
<div class=\"modal fade\" id=\"miModalAdd\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"miModalAdd\" aria-hidden=\"true\">
  <div class=\"modal-dialog modal-lg\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"miModalAdd\">";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["titulo_tabla"]) ? $context["titulo_tabla"] : null), "html", null, true);
        echo "</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
        <form class=\"container\" name=\"envioDatos\" id=\"envioDatos\" action=\"javascript:EnviarFormulario()\" method=\"POST\">
          
  \t\t<div class=\"row\">
        \t<div class=\"col-md-6 mb-3\">
    \t\t\t  <label for=\"empleado\">Empleado</label>    \t\t\t
    \t\t\t  <input type=\"text\" class=\"form-control\" name=\"empleado\" id=\"empleado\" aria-describedby=\"empleado\" placeholder=\"Nombre Empleado\"   value=\"\" required/>
  \t\t\t  </div>
          <div class=\"col-md-6 mb-3\">
            <label for=\"selectTipoDoc\">Tipo Documento</label>
             <select class=\"form-control\" id=\"selectTipoDoc\" name=\"selectTipoDoc\" required>
               ";
        // line 24
        echo (isset($context["select_tipoDoc"]) ? $context["select_tipoDoc"] : null);
        echo "
             </select>   
        </div>
  \t\t</div>
  \t\t<div class=\"row\">
  \t\t\t<div class=\"col-md-6 mb-3\">
    \t\t\t<label for=\"docu\">Documento</label>
    \t\t\t<input type=\"text\" class=\"form-control\" name=\"docu\" id=\"docu\" aria-describedby=\"docu\" placeholder=\"Numero Documento\" value=\"\" required />
    \t\t\t<span class=\"help-block\" id=\"error\"></span>
  \t\t\t</div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"selectArea\">Area</label>
          <select class=\"form-control\" id=\"selectArea\" name=\"selectArea\" required>
            ";
        // line 37
        echo (isset($context["select_area"]) ? $context["select_area"] : null);
        echo "
          </select>   
        </div>
  \t\t</div>
  \t\t<div class=\"row\">  \t\t\t
  \t\t\t<div class=\"col-md-6 mb-3\">
    \t\t\t<label for=\"email\">Correo Electronico</label>
    \t\t\t<input type=\"email\" class=\"form-control\" name=\"email\" id=\"email\" aria-describedby=\"email\" placeholder=\"Correo\" value=\"\" />
  \t\t\t</div>
        <div class=\"col-md-6 mb-3\">
          <label for=\"selcetRol\">Rol</label>
          <select class=\"form-control\" name=\"selcetRol\" id=\"selcetRol\" required>
            ";
        // line 49
        echo (isset($context["select_rol"]) ? $context["select_rol"] : null);
        echo "
          </select>   
        </div>
  \t\t</div>
  \t\t<div class=\"row\">  \t\t\t
  \t\t\t<div class=\"col-md-6 mb-3\">
    \t\t\t<label for=\"selectEstado\">Estado</label>
    \t\t\t<select class=\"form-control\" name=\"selectEstado\" id=\"selectEstado\" required>
    \t\t\t\t";
        // line 57
        echo (isset($context["select_estado"]) ? $context["select_estado"] : null);
        echo "
    \t\t\t</select> \t
  \t\t\t</div>
        <div class=\"col-md-6 mb-3\">
            <label for=\"selectTipoContra\">Tipo Contrato</label>
            <select class=\"form-control\" name=\"selectTipoContra\" id=\"selectTipoContra\" required>
                ";
        // line 63
        echo (isset($context["selectTipoContra"]) ? $context["selectTipoContra"] : null);
        echo "
            </select>   
         </div>
  \t\t</div>
      <div class=\"row\">         
            <div class=\"col-md-6 mb-3\">
              <label for=\"fechIngreCom\">Fecha Ingreso Compañia</label>
                <div class=\"input-append date form_datetime\" >
                     <input type=\"text\" class=\"form-control\" name=\"fechIngreCom\" id=\"fechIngreCom\" value=\"\" readonly>
                     <span class=\"add-on\"><i class=\"icon-remove\"></i></span>
                     <span class=\"add-on\"><i class=\"icon-calendar\"></i></span>
                </div>             
            </div>
            <div class=\"col-md-6 mb-3\">
          <label for=\"cargo\">Cargo</label>          
           <select class=\"form-control\" name=\"selectCargo\" id=\"selectCargo\" required>
                ";
        // line 79
        echo (isset($context["selectCargo"]) ? $context["selectCargo"] : null);
        echo "
            </select>
        </div>
      </div>
            <input type=\"hidden\" name=\"id\" id=\"id\" value=\"";
        // line 83
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosUsuario"]) ? $context["datosUsuario"] : null), "id", array()), "html", null, true);
        echo "\" />
            <input type=\"hidden\" name=\"opcion\" id=\"opcion\" value=\"";
        // line 84
        echo twig_escape_filter($this->env, (isset($context["opcion"]) ? $context["opcion"] : null), "html", null, true);
        echo "\" />
            <input type=\"hidden\" name=\"idMenu\" id=\"idMenu\" value=\"";
        // line 85
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo "\" />
  \t
  \t\t
        </form>
    </div>  
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cerrar</button>
        <button type=\"submit\" form=\"envioDatos\" class=\"btn btn-primary\">Guardar Empleado</button>
      </div>
    </div>
  </div>
</div>


<script>
\t\$().ready(function(){
\t\t\$(\"#envioDatos\").validate();
\t});

  //\$('#fechIngreCom').datetimepicker();
  \$(\".form_datetime\").datetimepicker({
        format: \"yyyy/mm/dd\",
        autoclose: true,
        todayBtn: true
        //startDate: \"2013-02-14 10:00\",
        //minuteStep: 10
    });


function usuarioValido(){
           
\t\tvar usuario=\$('#usuario').val();                
\t\tfor(var i=0; i<usuario.length; i++){
\t\t\tif(usuario[i]==' '){
\t\t\t\treturn false;
\t\t\t}
\t\t}
\t\treturn true;
}

\tfunction EnviarFormulario(){
\t\t
\t\tif(usuarioValido()){                    
\t\t\tif(nombreValido()=='valido'){
\t\t\t\tif(documentoValido()=='valido'){
\t\t\t\t\tvar request = \$.ajax({
\t\t\t\t\t\turl:'index_blank.php?component=Usuario&method=guardarUsuario',
\t\t\t\t\t\ttype: \"POST\",
\t\t\t\t\t\tdata:\$('#envioDatos').serialize(),
            dataType: \"html\"         
\t\t\t\t\t});
          request.done(function(msm) {

                \$('#miModal').modal('hide');
                location.reload('index_blank.php?component=Usuario&method=mostrarUsuarios'+";
        // line 139
        echo twig_escape_filter($this->env, (isset($context["idMenu"]) ? $context["idMenu"] : null), "html", null, true);
        echo ");
          });

\t\t\t\t}
\t\t\t\telse{
\t\t\t\t\talert('El No. Documento que desea asignar ya se encuentra atado a otro usuario.\\nPor favor verifique.')
\t\t\t\t};
\t\t\t}
\t\t\telse{
\t\t\t\talert('El usuario que desea asignar ya se encuentra en uso.');
\t\t\t}
\t\t}
\t\telse{
\t\t\talert('El usuario que desea asignar contiene espacios en blanco.\\nPor Favor verifique.');
\t\t}
\t}

\tfunction nombreValido(){
\t\tvar usuario = \$('#usuario').val();
\t\tvar ident = \$('#id').val();
\t\tvar responder='';
                
\t\t\$.ajax({
\t\t\turl:'index_blank.php?component=Usuario&method=validarRepetido',
\t\t\ttype: \"POST\",
\t\t\tasync:false,
\t\t\tdata:'login='+usuario+'&id='+ident,
\t\t\tsuccess: function (msm){
\t\t\t\tresponder=msm;
\t\t\t}
\t\t});     
               //alert(\$.trim(responder));
\t\treturn \$.trim(responder);
\t}

\tfunction documentoValido(){
\t\tvar documento = \$('#docu').val();
\t\tvar ident = \$('#id').val();
\t\tvar responder='';
                
\t\t\$.ajax({
\t\t\turl:'index_blank.php?component=Usuario&method=validarDocumento',
\t\t\ttype: \"POST\",
\t\t\tasync:false,
\t\t\tdata:'numeroDocumento='+documento+'&id='+ident,
\t\t\tsuccess: function (msm){
\t\t\t\tresponder=msm;
\t\t\t}
\t\t});                 
\t\treturn \$.trim(responder);
\t}

</script>";
    }

    public function getTemplateName()
    {
        return "agregarNomina.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  190 => 139,  133 => 85,  129 => 84,  125 => 83,  118 => 79,  99 => 63,  90 => 57,  79 => 49,  64 => 37,  48 => 24,  29 => 8,  19 => 1,);
    }
}
