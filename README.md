## Multi-Domain Laravel Application by Salim Albadi

This project is a dimo for rum Multi-Domain in same back-end using Laravel framework. 

migration and Modal that will save your domain info in databse. 

 public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
    
for me its only need name of domain for this Demo.

then create Middleware File to check if domain register in your databse

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

if domain not in your database it will show not find 404 page, (you can do some logic also here for example if the owner of the domain is a subscriber and his account is activated, if you are selling a service).

After that we add this to http kernel file:

 protected $routeMiddleware = [
        //other stuff...
        'domain.verify' => 'App\Http\Middleware\VerifiedDomain',
    ];

Finally you can implement this in a route in various scenarios.

Route::group(['domain' => '127.0.0.1'], function(){
    Route::get('/', function(){ return 'this is the main domain page'; });
});

Route::group(['domain' => 'sup.127.0.0.1'], function(){
    Route::get('/', function(){ return 'this is sup-domain page'; });
});

Route::group(['domain' => '{all}'], function(){
   
    Route::get('/', function(){ return 'this is domain route to your back-end ';})->where('all', '.*')->middleware('domain.verify');

});

