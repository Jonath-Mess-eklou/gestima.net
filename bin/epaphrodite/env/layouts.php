<?php

namespace bin\epaphrodite\env;

class layouts
{

    /**
     * ******************************************************************************
     * Get login template
     *
     * @return string
     */
    public function login()
    {

        return "layouts/template/__default_login.html.twig";
    }

    /**
     * ******************************************************************************
     * Get default template ( when user are not connected )
     *
     * @return string
     */
    public function main()
    {

        return "layouts/template/__default.main.html.twig";
    }

    /**
     * ******************************************************************************
     * Get default template ( when user are not connected )
     *
     * @return string
     */
    public function admin(?int $key = null)
    {

        $urls =
            [
                1 => "layouts/template/__default.super.admin.html.twig",
                2 => "layouts/template/__default.admin.html.twig",
                3 => "layouts/template/__default.all.users.html.twig",
            ];

        return $urls[$key];
    }

    /**
     * ******************************************************************************
     * Get default template ( forms template )
     *
     * @return string
     */
    public function forms()
    {

        return "layouts/widgets/__widgets.forms.html.twig";
    }

    /**
     * ******************************************************************************
     * Get default template ( forms template )
     *
     * @return string
     */
    public function charts()
    {

        return "layouts/widgets/__widgets.charts.html.twig";
    }

    /**
     * ******************************************************************************
     * Get default template ( error template )
     *
     * @return string
     */
    public function errors()
    {

        return "layouts/template/__default.errors.html.twig";
    }

    /**
     * ******************************************************************************
     * Get default template ( show messages )
     *
     * @return string
     */
    public function msg()
    {

        return "layouts/widgets/__widgets.messages.html.twig";
    }

    /**
     * ******************************************************************************
     * Get default template ( breadcrumbs template )
     *
     * @return string
     */
    public function breadcrumbs()
    {

        return "layouts/widgets/__widgets.breadcrumb.html.twig";
    }

    /**
     * ******************************************************************************
     * Get default template ( pagination template )
     *
     * @return string
     */
    public function pagination()
    {

        return "layouts/widgets/__widgets.pagination.html.twig";
    }
}
