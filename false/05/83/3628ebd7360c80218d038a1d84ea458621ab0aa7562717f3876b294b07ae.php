<?php

/* generarDesprenPdf.html */
class __TwigTemplate_05833628ebd7360c80218d038a1d84ea458621ab0aa7562717f3876b294b07ae extends Twig_Template
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
<div id=\"certiLabr\">
        <form method=\"POST\" name=\"ceLaboral\" id=\"ceLaboral\" action=\"crearPDF.php\" target=\"_blank\">
        \t<div id=\"certiLab\">
        \t\t<div class=\"card cardEtlDesp card-outline-info\">
                   <div class=\"card-header\" >
                       <img class=\"card-img-top imageDespren\" src=\"imagenes/logo1.png\" alt=\"Card image cap\"/>
                        ETL SOLUCIONES INFORMATICAS Y DE SOFTWARE S.A.S 
                         <div class=\"divcenter\">NIT.900.680.844-0</div>
                   </div>
                   <div class=\"card-body\">
                     <table class=\"tabDespren\">                       
                        <tr>
                          <td>
                            Cedula:
                          </td>
                          <td>
                             ";
        // line 18
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEnca"]) ? $context["datosEnca"] : null), "numeroDocumento", array()), "html", null, true);
        echo "
                          </td>
                          <td>
                            Nombre:
                          </td>
                          <td>
                             ";
        // line 24
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEnca"]) ? $context["datosEnca"] : null), "nombre", array()), "html", null, true);
        echo "
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Cargo:
                          </td>
                          <td>
                             ";
        // line 32
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEnca"]) ? $context["datosEnca"] : null), "cargo", array()), "html", null, true);
        echo "
                          </td>
                          <td>
                            Periodo:
                          </td>
                          <td>
                             ";
        // line 38
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEnca"]) ? $context["datosEnca"] : null), "periodo", array()), "html", null, true);
        echo "
                          </td>
                        </tr>
                        
                        
                        <thead>
                             <tr>
                              <th colspan=\"4\"><center>INGRESOS</center> </th>
                         </tr>
                             <tr class=\"tabDesprenIngretr\">
                                <td class=\"tabDesprenIngretd\">Codigo</td>
                                <td class=\"tabDesprenIngretd\">Concepto</td>
                                <td class=\"tabDesprenIngretd\">Cantidad</td>
                                <td class=\"tabDesprenIngretd\">Valor</td>
                           </tr>
                           </thead>
                          <tbody>                            
                              ";
        // line 55
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["datosCertIngre"]) ? $context["datosCertIngre"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["datoscertIngresos"]) {
            // line 56
            echo "                                <tr class=\"tabDesprenIngretr\">
                                  <td class=\"tabDesprenIngretd\">";
            // line 57
            echo twig_escape_filter($this->env, $this->getAttribute($context["datoscertIngresos"], "codigo", array()), "html", null, true);
            echo "</td>
                                  <td class=\"tabDesprenIngretd\">";
            // line 58
            echo twig_escape_filter($this->env, $this->getAttribute($context["datoscertIngresos"], "descripcion", array()), "html", null, true);
            echo "</td>
                                  <td class=\"tabDesprenIngretd\">";
            // line 59
            echo twig_escape_filter($this->env, $this->getAttribute($context["datoscertIngresos"], "cantidad", array()), "html", null, true);
            echo "</td>
                                  <td class=\"tabDesprenIngretd\">";
            // line 60
            echo twig_escape_filter($this->env, $this->getAttribute($context["datoscertIngresos"], "valor", array()), "html", null, true);
            echo "</td>
                                </tr>
                              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['datoscertIngresos'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 63
        echo "                                <tr class=\"tabDesprenIngretr\">
                                  <td class=\"tabDesprenIngretd\"></td>
                                  <td class=\"tabDesprenIngretd\">Total Ingresos</td>
                                  <td class=\"tabDesprenIngretd\"></td>
                                  <td class=\"tabDesprenIngretd\">";
        // line 67
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["totales"]) ? $context["totales"] : null), "total", array()), "html", null, true);
        echo "</td>
                                </tr>
                                <tr class=\"tabDesprenIngretr\">
                                  <td class=\"tabDesprenIngretd\"></td>
                                  <td td class=\"tabDesprenIngretd\">Total Neto</td>
                                  <td class=\"tabDesprenIngretd\"></td>
                                  <td class=\"tabDesprenIngretd\">";
        // line 73
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["totales"]) ? $context["totales"] : null), "totalNeto", array()), "html", null, true);
        echo "</td>
                                </tr>
                            </tbody>
                            <tr>
                              <td>
                              <thead>
                             <tr>
                              <th colspan=\"4\"><center>EGRESOS</center> </th>
                             </tr>
                             <tr class=\"tabDesprenIngretr\">
                                <td class=\"tabDesprenIngretd\">Codigo</td>
                                <td class=\"tabDesprenIngretd\">Concepto</td>
                                <td class=\"tabDesprenIngretd\">Cantidad</td>
                                <td class=\"tabDesprenIngretd\">Valor</td>
                           </tr>
                           </thead>
                           <tbody>                            
                              ";
        // line 90
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["datosCertEgre"]) ? $context["datosCertEgre"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["datosCertEgresos"]) {
            // line 91
            echo "                                <tr class=\"tabDesprenIngretr\">
                                  <td class=\"tabDesprenIngretd\">";
            // line 92
            echo twig_escape_filter($this->env, $this->getAttribute($context["datosCertEgresos"], "codigo", array()), "html", null, true);
            echo "</td>
                                  <td class=\"tabDesprenIngretd\">";
            // line 93
            echo twig_escape_filter($this->env, $this->getAttribute($context["datosCertEgresos"], "descripcion", array()), "html", null, true);
            echo "</td>
                                  <td class=\"tabDesprenIngretd\">";
            // line 94
            echo twig_escape_filter($this->env, $this->getAttribute($context["datosCertEgresos"], "cantidad", array()), "html", null, true);
            echo "</td>
                                  <td class=\"tabDesprenIngretd\">";
            // line 95
            echo twig_escape_filter($this->env, $this->getAttribute($context["datosCertEgresos"], "valor", array()), "html", null, true);
            echo "</td>
                                </tr>
                              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['datosCertEgresos'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 98
        echo "                              <tr class=\"tabDesprenIngretr\">
                                  <td colspan=\"1\" class=\"tabDesprenIngretd\"></td>
                                  <td class=\"tabDesprenIngretd\">Total Deducciones</td>
                                  <td class=\"tabDesprenIngretd\"></td>
                                  <td class=\"tabDesprenIngretd\">";
        // line 102
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["totales"]) ? $context["totales"] : null), "totalDeducciones", array()), "html", null, true);
        echo "</td>
                                </tr>
                            </tbody>
                            </td>
                            </tr>
                        <!-- </table>
                        </tr>
                         <table class=\"tabDesprenIngre\">
                           <thead>
                             <tr>
                              <th colspan=\"4\"><center>INGRESOS</center> </th>
                             </tr>
                             <tr class=\"tabDesprenIngretr\">
                                <td class=\"tabDesprenIngretd\">Codigo</td>
                                <td class=\"tabDesprenIngretd\">Concepto</td>
                                <td class=\"tabDesprenIngretd\">Cantidad</td>
                                <td class=\"tabDesprenIngretd\">Valor</td>
                           </tr>
                           </thead>
                           <tbody>                            
                              ";
        // line 122
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["datosCertIngre"]) ? $context["datosCertIngre"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["datoscertIngresos"]) {
            // line 123
            echo "                                <tr class=\"tabDesprenIngretr\">
                                  <td class=\"tabDesprenIngretd\">";
            // line 124
            echo twig_escape_filter($this->env, $this->getAttribute($context["datoscertIngresos"], "codigo", array()), "html", null, true);
            echo "</td>
                                  <td class=\"tabDesprenIngretd\">";
            // line 125
            echo twig_escape_filter($this->env, $this->getAttribute($context["datoscertIngresos"], "descripcion", array()), "html", null, true);
            echo "</td>
                                  <td class=\"tabDesprenIngretd\">";
            // line 126
            echo twig_escape_filter($this->env, $this->getAttribute($context["datoscertIngresos"], "cantidad", array()), "html", null, true);
            echo "</td>
                                  <td class=\"tabDesprenIngretd\">";
            // line 127
            echo twig_escape_filter($this->env, $this->getAttribute($context["datoscertIngresos"], "valor", array()), "html", null, true);
            echo "</td>
                                </tr>
                              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['datoscertIngresos'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 130
        echo "                                <tr class=\"tabDesprenIngretr\">
                                  <td class=\"tabDesprenIngretd\"></td>
                                  <td td class=\"tabDesprenIngretd\">Total Ingresos</td>
                                  <td class=\"tabDesprenIngretd\"></td>
                                  <td class=\"tabDesprenIngretd\">";
        // line 134
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["totales"]) ? $context["totales"] : null), "total", array()), "html", null, true);
        echo "</td>
                                </tr>
                                <tr class=\"tabDesprenIngretr\">
                                  <td class=\"tabDesprenIngretd\"></td>
                                  <td td class=\"tabDesprenIngretd\">Total Neto</td>
                                  <td class=\"tabDesprenIngretd\"></td>
                                  <td class=\"tabDesprenIngretd\">";
        // line 140
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["totales"]) ? $context["totales"] : null), "totalNeto", array()), "html", null, true);
        echo "</td>
                                </tr>
                            </tbody>
                         </table>
                        <table class=\"tabDesprenEgre\">
                           <thead>
                             <tr>
                              <th colspan=\"4\"><center>EGRESOS</center> </th>
                             </tr>
                             <tr class=\"tabDesprenIngretr\">
                                <td class=\"tabDesprenIngretd\">Codigo</td>
                                <td class=\"tabDesprenIngretd\">Concepto</td>
                                <td class=\"tabDesprenIngretd\">Cantidad</td>
                                <td class=\"tabDesprenIngretd\">Valor</td>
                           </tr>
                           </thead>
                           <tbody>                            
                              ";
        // line 157
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["datosCertEgre"]) ? $context["datosCertEgre"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["datosCertEgresos"]) {
            // line 158
            echo "                                <tr class=\"tabDesprenIngretr\">
                                  <td class=\"tabDesprenIngretd\">";
            // line 159
            echo twig_escape_filter($this->env, $this->getAttribute($context["datosCertEgresos"], "codigo", array()), "html", null, true);
            echo "</td>
                                  <td class=\"tabDesprenIngretd\">";
            // line 160
            echo twig_escape_filter($this->env, $this->getAttribute($context["datosCertEgresos"], "descripcion", array()), "html", null, true);
            echo "</td>
                                  <td class=\"tabDesprenIngretd\">";
            // line 161
            echo twig_escape_filter($this->env, $this->getAttribute($context["datosCertEgresos"], "cantidad", array()), "html", null, true);
            echo "</td>
                                  <td class=\"tabDesprenIngretd\">";
            // line 162
            echo twig_escape_filter($this->env, $this->getAttribute($context["datosCertEgresos"], "valor", array()), "html", null, true);
            echo "</td>
                                </tr>
                              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['datosCertEgresos'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 165
        echo "                              <tr class=\"tabDesprenIngretr\">
                                  <td class=\"tabDesprenIngretd\"></td>
                                  <td td class=\"tabDesprenIngretd\">Total Deducciones</td>
                                  <td class=\"tabDesprenIngretd\"></td>
                                  <td class=\"tabDesprenIngretd\">";
        // line 169
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["totales"]) ? $context["totales"] : null), "totalDeducciones", array()), "html", null, true);
        echo "</td>
                                </tr>
                            </tbody>
                         </table>-->
                      </table>

                    
                
                    <!--<div class=\"card cardEtl card-outline-info\">
                       <img class=\"card-img-top imageCertiLab\" src=\"imagenes/desCertiLaboralCon.png\" alt=\"Card image cap\">
                       <div class=\"card-block\">
                          <h4 class=\"card-title\">Certificado Laboral Con Sueldo</h4>
                        </div>
                      <div class=\"card-block\">
                       <a href=\"#\" id=\"cerLab\" onclick=\"generarCetiLaSulbPdf()\" class=\"card-link btn btn-outline-primary\">Generar</a>
                      </div>
                    </div>-->
                  </div>
                </div>
            </div>
\t\t\t<input type=\"hidden\" name=\"datosCertificado\" id=\"datosCertificado\" value=\"\">
        </form>     
           
</div>

<script>

\$().ready(function(){
    
\t\$(\"#ceLaboral\").validate();
   
     var shelf_clone = \$(\"#certiLab\").clone(); 
     var shelf = shelf_clone.prop(\"outerHTML\");
     var datos = \$(\"#datosCertificado\").val(shelf);
     \$(\"#ceLaboral\").submit();
     \$(\"#certiLabr\").hide();
});
    

</script>";
    }

    public function getTemplateName()
    {
        return "generarDesprenPdf.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  305 => 169,  299 => 165,  290 => 162,  286 => 161,  282 => 160,  278 => 159,  275 => 158,  271 => 157,  251 => 140,  242 => 134,  236 => 130,  227 => 127,  223 => 126,  219 => 125,  215 => 124,  212 => 123,  208 => 122,  185 => 102,  179 => 98,  170 => 95,  166 => 94,  162 => 93,  158 => 92,  155 => 91,  151 => 90,  131 => 73,  122 => 67,  116 => 63,  107 => 60,  103 => 59,  99 => 58,  95 => 57,  92 => 56,  88 => 55,  68 => 38,  59 => 32,  48 => 24,  39 => 18,  19 => 1,);
    }
}
