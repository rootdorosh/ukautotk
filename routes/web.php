<?php

use App\Base\CoreHelper;

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

Route::get('flush', function() {
    \Cache::flush();
});


Route::get('/', function() {
});


foreach (CoreHelper::getModules() as $module) {
    foreach (['Admin', 'Front'] as $ui) {
        $file = app_path() . '/Modules/' . $module . '/' . $ui . '/Http/routes.php';
        if (is_file($file)) {
            include $file;
        }
    }
}

