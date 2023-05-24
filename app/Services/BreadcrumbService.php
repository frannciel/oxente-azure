<?php

namespace App\Services;

use App\Models\Breadcrumb;

class BreadcrumbService
{
    protected $breadcrumbs;

    /**
     * [Description for generate]
     *
     * @param string $route
     * 
     * @return Colletions $breadcrumbs
     * 
     */
    public function generate(string $route)
    {
        try
        {
            $this->breadcrumbs = collect();
            $this->build($route);

            return [
                'status' => true,
                'message' => 'Breadcrumb gerado com sucesso!',
                'data' => $this->breadcrumbs
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Breadcrumbs não gerados ocorreu durante a execução',
                'error' => $e
            ];
        }
    }

    /**
     * [Description for generateWithParam]
     *
     * @param string $route
     * @param array $parameters
     * 
     * @return Colletions $breadcrumbs
     * 
     */
    public function generateWithParam(string $route, array $parameters)
    {
        try
        {
            $this->breadcrumbs = collect();
            $this->buildParam($route, $parameters);

            return [
                'status' => true,
                'message' => 'Breadcrumb gerado com sucesso!',
                'data' => $this->breadcrumbs
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Breadcrumbs não gerados ocorreu durante a execução',
                'error' => $e
            ];
        }
    }

    protected function build (string $route)
    {
        $breadcrumb = Breadcrumb::where('route_name', $route)->first();
        $this->breadcrumbs->prepend(collect([
            'title' =>  $breadcrumb->title, 
            'url' => route($breadcrumb->route_name)
        ])); // add collect breadcrumb node
        if( $breadcrumb->father != null)
            $this->build($breadcrumb->father->route_name);
    }

    protected function buildParam (string $route, array $parameters)
    {
        $breadcrumb = Breadcrumb::where('route_name', $route)->first();
        $url;   
        $title = $breadcrumb->title;

        if ($breadcrumb->has_parameters) {
            
            if(isset($parameters[$route]['parameters'])){
                $url = route($breadcrumb->route_name, $parameters[$route]['parameters']);
            } else{
                $url = route($breadcrumb->route_name);
            }

            if (isset($parameters[$route]['title'])) {
                $title = $breadcrumb->title." ".$parameters[$route]['title'];
            } else{
                $title = $breadcrumb->title;
            }
        } else {
            $url = route($breadcrumb->route_name);    
            $title = $breadcrumb->title;
        }
        
        $this->breadcrumbs->prepend(collect(['title' =>  $title, 'url' => $url])); // add collect breadcrumb node
        if( $breadcrumb->father != null)
            $this->buildParam($breadcrumb->father->route_name, $parameters);
    }
}
