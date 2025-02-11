<?php

return [

    'custom_template' => true,

    /*
    |--------------------------------------------------------------------------
    | Crud Generator Template Stubs Storage Path
    |--------------------------------------------------------------------------
    |
    | Here you can specify your custom template path for the generator.
    |
     */

    'path' => base_path('resources/crud-generator/'),

    /**
     * Columns number to show in view's table.
     */
    'view_columns_number' => 3,

    /**
     * Delimiter for template vars
     */
    'custom_delimiter' => ['%%', '%%'],

    /*
    |--------------------------------------------------------------------------
    | Dynamic templating
    |--------------------------------------------------------------------------
    |
    | Here you can specify your customs templates for the generator.
    | You can set new templates or delete some templates if you do not want them.
    | You can also choose which values are passed to the views and you can specify a custom delimiter for all templates
    |
    | Those values are available :
    |
    | formFields
    | formFieldsHtml
    | varName
    | crudName
    | crudNameCap
    | crudNameSingular
    | primaryKey
    | modelName
    | modelNameCap
    | viewName
    | routePrefix
    | routePrefixCap
    | routeGroup
    | formHeadingHtml
    | formBodyHtml
    |
    |
     */
    'dynamic_view_template' => [
        'index' => ['crudNameSingular', 'viewTemplateDir', 'formHeadingHtml', 'formBodyHtml', 'crudName', 'crudNameCap', 'modelName', 'viewName', 'routeGroup', 'primaryKey'],
        'form' => ['formFieldsHtml'],
        'create' => ['crudNameSingular', 'modelNamespace', 'crudName', 'crudNameCap', 'modelName', 'modelNameCap', 'viewName', 'routeGroup', 'viewTemplateDir'],
        'edit' => ['crudName', 'crudNameSingular', 'crudNameCap', 'modelNameCap', 'modelName', 'viewName', 'routeGroup', 'primaryKey', 'viewTemplateDir'],
        'show' => ['viewTemplateDir', 'formHeadingHtml', 'formBodyHtml', 'formBodyHtmlForShowView', 'crudName', 'crudNameSingular', 'crudNameCap', 'modelName', 'viewName', 'routeGroup', 'primaryKey'],
        'search-form' => ['formHeadingHtml', 'formBodyHtml', 'formBodyHtmlForShowView', 'crudName', 'crudNameSingular', 'crudNameCap', 'modelName', 'viewName', 'routeGroup', 'primaryKey'],
        'view' => ['formHeadingHtml', 'formBodyHtml', 'formBodyHtmlForShowView', 'crudName', 'crudNameSingular', 'crudNameCap', 'modelName', 'viewName', 'routeGroup', 'primaryKey'],
        /*
         * Add new stubs templates here if you need to, like action, datatable...
         * custom_template needs to be activated for this to work
         */
    ]
    
    // php artisan crud:generate TraderDistributorBuyer --fields_from_file="resources/crud-generator/fields.json" --view-path=monitoring --controller-namespace=Monitoring/PO --model-namespace=Models\\Monitoring\\PO --route-group=Monitoring\\PO --form-helper=laravelcollective

    //php artisan crud:generate Cig --fields_from_file="resources/crud-generator/fields.json" --view-path=monitoring --controller-namespace=Monitoring --model-namespace=Models/Monitoring --route-group=Monitoring --form-helper=laravelcollective

    // php artisan crud:generate Posts --fields_from_file="resources/crud-generator/fields.json" --view-path=admin --controller-namespace=Admin --route-group=admin --form-helper=laravelcollective

    // php artisan crud:generate Posts --fields='title#string;content#text;category#select#options={"technology": "Technology", "tips": "Tips", "health": "Health"}' --view-path=admin --controller-namespace=Admin --route-group=admin --form-helper=laravelcollective --validations='content#required'

];
