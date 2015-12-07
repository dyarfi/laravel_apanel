var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */
	
var elixir = require('laravel-elixir');

elixir(function(mix) {
    // mix.less('app.less');
    mix.styles([
        "app.css",
        "main.css"
    ], 'public/css/all.css').version("public/css/all.css");
});
