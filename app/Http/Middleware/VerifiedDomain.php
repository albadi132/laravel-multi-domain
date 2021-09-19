<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Domain;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VerifiedDomain {

    protected $Domain;

    public function handle($request, Closure $next){

        $domain = $_SERVER['SERVER_NAME'];
        $Domain = Domain::where('name', $domain)->first();

        if(!$Domain){ throw new NotFoundHttpException; }

        $Site = $Domain->name;
        if(!$Site){
            throw new NotFoundHttpException;
        }

        $this->Domain = $Domain;

        
        return $next($request);
    }

    public function getDomain(){
        return $this->Domain;
    }

    public function getSite(){
      
        return $this->Domain->name;
    }

}