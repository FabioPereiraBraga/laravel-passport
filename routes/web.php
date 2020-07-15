<?php

use GuzzleHttp\Client;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function(){
    $query = http_build_query([
     'client_id'=>'910c978a-7d00-4933-b76c-2b6c1d65c940',
     'redirect_url'=>'http://localhost:8000/callback',
     'response_type'=>'code',
     'scope'=>''
    ]);
    return redirect("http://localhost:8000/oauth/authorize?$query");
  });
  
  Route::get('callback', function(HttpRequest $request){
    $code = $request->get('code');
    $http = new Client();
    $response = $http->post('http://localhost:8000/oauth/token',[
        'json' => [
            'client_id' => '910c978a-7d00-4933-b76c-2b6c1d65c940',
            'client_secret'=>'8pUSiSv1vMh1HRr9YaNfUMOJr8Dloj8biIzCWyjx',
            'redirect_url'=>'http://localhost:8000/callback',
            'code'=>$code,
            'grant_type'=>'authorization_code'
        ]
    ]);
  
    dd( json_decode( $response->getBody()) );
  });