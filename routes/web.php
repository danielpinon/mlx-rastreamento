<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

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
    return redirect()->route('login');
});


Route::group(['prefix'=>'admin','middleware' => 'auth', 'namespace' => 'Admin'], function () {
	// Página Inicial
	Route::get('/home', 'HomeController@index')->name('home');
	
	// Gerenciador de Facções
	Route::group(['prefix'=>'faccoes'], function () {
		Route::get('/','FaccoesController@index')->name('admin.faccoes.index');
		Route::get('{id}/editar', 'FaccoesController@edit')->name('admin.faccoes.edit');
		Route::get('{id}/delete', 'FaccoesController@delete')->name('admin.faccoes.delete');
		Route::post('create', 'FaccoesController@create')->name('admin.faccoes.create');
		Route::post('{id}/update', 'FaccoesController@update')->name('admin.faccoes.update');
		Route::group(['prefix'=>'{token}'], function () {
			Route::get('/','FaccoesController@info')->name('admin.faccoes.info');
			Route::group(['prefix'=>'usuarios', 'namespace'=>'Faccoes'], function () {
				Route::get('/', 'UsersController@index')->name('admin.faccoes.details.users');
				Route::post('create', 'UsersController@create')->name('admin.faccoes.details.users.create');
				Route::get('{tokenUser}/delete', 'UsersController@delete')->name('admin.faccoes.details.users.delete');
				Route::post('{tokenUser}/update', 'UsersController@update')->name('admin.faccoes.details.users.update');
			});
		});		
	});
	// Gerenciador de Setores
	Route::group(['prefix'=>'setores'], function () {
		Route::get('/','SetoresController@index')->name('admin.setores.index');
		Route::get('{id}/apagar','SetoresController@delete')->name('admin.setores.apagar');
		Route::post('create','SetoresController@create')->name('admin.setores.create');
		Route::post('reorganiza','SetoresController@reorganiza')->name('admin.setores.reorganiza');
	});
	// Gerenciador de Lote de Trabalho
	Route::group(['prefix'=>'lotes'], function () {
		Route::get('/','LotesController@index')->name('admin.lotes.index');
		Route::get('{token}/apagar','LotesController@delete')->name('admin.lotes.apagar');
		Route::get('{token}/printer','LotesController@printer')->name('admin.lotes.printer');
		Route::post('create','LotesController@create')->name('admin.lotes.create');
		Route::post('{token}/changestatus','LotesController@changestatus')->name('admin.lotes.changestatus');
		Route::group(['prefix'=>'{token}/itens'], function () {
			Route::get('/','LotesController@itens')->name('admin.lotes.itens');
			Route::get('add','LotesController@addItem')->name('admin.lotes.itens.add');
			Route::get('{id}/delete','LotesController@deleteItem')->name('admin.lotes.itens.delete');
		});
	});
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::post('registro', 'UserController@registro')->name('user.registro');
	Route::post('update', 'UserController@update')->name('user.update');
	Route::get('delete/{id}','UserController@delete')->name('user.delete');
});
