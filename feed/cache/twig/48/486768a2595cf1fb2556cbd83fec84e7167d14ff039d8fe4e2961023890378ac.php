<?php

/* forms/fields/blueprint/blueprint.html.twig */
class __TwigTemplate_f628e7934be19c62ba61e55915d04abc33053314311ceda07765ae18a270a208 extends Twig_Template
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
        echo "<input
    data-grav-field=\"hidden\"
    data-grav-disabled=\"false\"
    type=\"hidden\"
    class=\"input\"
    ";
        // line 6
        if (($this->getAttribute(($context["field"] ?? null), "disabled", array()) || ($context["isDisabledToggleable"] ?? null))) {
            echo "disabled=\"disabled\"";
        }
        // line 7
        echo "    name=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Grav\Common\Twig\TwigExtension')->fieldNameFilter((($context["scope"] ?? null) . $this->getAttribute(($context["field"] ?? null), "name", array()))), "html", null, true);
        echo "\"
    value=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute(($context["blueprints"] ?? null), "name", array()), "html", null, true);
        echo "\" />
";
    }

    public function getTemplateName()
    {
        return "forms/fields/blueprint/blueprint.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  35 => 8,  30 => 7,  26 => 6,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<input
    data-grav-field=\"hidden\"
    data-grav-disabled=\"false\"
    type=\"hidden\"
    class=\"input\"
    {% if field.disabled or isDisabledToggleable %}disabled=\"disabled\"{% endif %}
    name=\"{{ (scope ~ field.name)|fieldName }}\"
    value=\"{{ blueprints.name }}\" />
", "forms/fields/blueprint/blueprint.html.twig", "/Users/markbrand/Sites/sites/wl-schermen/www/feed/user/plugins/admin/themes/grav/templates/forms/fields/blueprint/blueprint.html.twig");
    }
}
