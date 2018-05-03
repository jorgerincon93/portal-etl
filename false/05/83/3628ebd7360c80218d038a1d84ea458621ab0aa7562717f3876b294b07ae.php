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
        echo "  ";
        echo twig_escape_filter($this->env, (isset($context["COMODIN"]) ? $context["COMODIN"] : null), "html", null, true);
        echo "

  <div id=\"certiLabr\">

          <form method=\"POST\" name=\"ceLaboral\" id=\"ceLaboral\" action=\"crearPDF.php\" target=\"_blank\">
          
          \t<div id=\"certiLab\">
              
          ";
        // line 9
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["meses"]) ? $context["meses"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["mes"]) {
            echo "     
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
            // line 25
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEnca"]) ? $context["datosEnca"] : null), "numeroDocumento", array()), "html", null, true);
            echo "
                            </td>
                            <td>
                              Nombre:
                            </td>
                            <td>
                               ";
            // line 31
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
            // line 39
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["datosEnca"]) ? $context["datosEnca"] : null), "cargo", array()), "html", null, true);
            echo "
                            </td>
                            <td>
                              Periodo:
                            </td>
                            <td> 
                              ";
            // line 45
            echo twig_escape_filter($this->env, $this->getAttribute($context["mes"], "mes", array()), "html", null, true);
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
            // line 62
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["datosCertIngre"]) ? $context["datosCertIngre"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["datoscertIngresos"]) {
                // line 63
                echo "                                  <tr class=\"tabDesprenIngretr\">
                                    <td class=\"tabDesprenIngretd\">";
                // line 64
                echo twig_escape_filter($this->env, $this->getAttribute($context["datoscertIngresos"], "codigo", array()), "html", null, true);
                echo "</td>
                                    <td class=\"tabDesprenIngretd\">";
                // line 65
                echo twig_escape_filter($this->env, $this->getAttribute($context["datoscertIngresos"], "descripcion", array()), "html", null, true);
                echo "</td>
                                    <td class=\"tabDesprenIngretd\">";
                // line 66
                echo twig_escape_filter($this->env, $this->getAttribute($context["datoscertIngresos"], "cantidad", array()), "html", null, true);
                echo "</td>
                                    <td class=\"tabDesprenIngretd\">";
                // line 67
                echo twig_escape_filter($this->env, $this->getAttribute($context["datoscertIngresos"], "valor", array()), "html", null, true);
                echo "</td>
                                  </tr>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['datoscertIngresos'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 70
            echo "                                  <tr class=\"tabDesprenIngretr\">
                                    <td class=\"tabDesprenIngretd\"></td>
                                    <td class=\"tabDesprenIngretd\">Total Ingresos</td>
                                    <td class=\"tabDesprenIngretd\"></td>
                                    <td class=\"tabDesprenIngretd\">";
            // line 74
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["totales"]) ? $context["totales"] : null), "total", array()), "html", null, true);
            echo "</td>
                                  </tr>
                                  <tr class=\"tabDesprenIngretr\">
                                    <td class=\"tabDesprenIngretd\"></td>
                                    <td td class=\"tabDesprenIngretd\">Total Neto</td>
                                    <td class=\"tabDesprenIngretd\"></td>
                                    <td class=\"tabDesprenIngretd\">";
            // line 80
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
            // line 97
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["datosCertEgre"]) ? $context["datosCertEgre"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["datosCertEgresos"]) {
                // line 98
                echo "                                  <tr class=\"tabDesprenIngretr\">
                                    <td class=\"tabDesprenIngretd\">";
                // line 99
                echo twig_escape_filter($this->env, $this->getAttribute($context["datosCertEgresos"], "codigo", array()), "html", null, true);
                echo "</td>
                                    <td class=\"tabDesprenIngretd\">";
                // line 100
                echo twig_escape_filter($this->env, $this->getAttribute($context["datosCertEgresos"], "descripcion", array()), "html", null, true);
                echo "</td>
                                    <td class=\"tabDesprenIngretd\">";
                // line 101
                echo twig_escape_filter($this->env, $this->getAttribute($context["datosCertEgresos"], "cantidad", array()), "html", null, true);
                echo "</td>
                                    <td class=\"tabDesprenIngretd\">";
                // line 102
                echo twig_escape_filter($this->env, $this->getAttribute($context["datosCertEgresos"], "valor", array()), "html", null, true);
                echo "</td>
                                  </tr>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['datosCertEgresos'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 105
            echo "                                <tr class=\"tabDesprenIngretr\">
                                    <td colspan=\"1\" class=\"tabDesprenIngretd\"></td>
                                    <td class=\"tabDesprenIngretd\">Total Deducciones</td>
                                    <td class=\"tabDesprenIngretd\"></td>
                                    <td class=\"tabDesprenIngretd\">";
            // line 109
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["totales"]) ? $context["totales"] : null), "totalDeducciones", array()), "html", null, true);
            echo "</td>
                                  </tr>
                              </tbody>
                              </td>
                              </tr>
                        </table>

                   
                    </div>
                  </div>

  <br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['mes'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 123
        echo "    
              </div>
  \t\t\t<input type=\"hidden\" name=\"datosCertificado\" id=\"datosCertificado\" value=\"\">

          </form>     

  </div>
<br>

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
        return array (  219 => 123,  198 => 109,  192 => 105,  183 => 102,  179 => 101,  175 => 100,  171 => 99,  168 => 98,  164 => 97,  144 => 80,  135 => 74,  129 => 70,  120 => 67,  116 => 66,  112 => 65,  108 => 64,  105 => 63,  101 => 62,  81 => 45,  72 => 39,  61 => 31,  52 => 25,  31 => 9,  19 => 1,);
    }
}
