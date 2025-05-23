/*
*  Scutum Admin_template
*  @version v1.0.1
*  @author tzd
*  @license http://themeforest.net/licenses

*  used in: plugins-code_editor.html
*/

var cmEditor;
var $codeEditor = $("#sc-code-editor");
scutum.plugins.codeEditor = {};
scutum.plugins.codeEditor.init = function () {
	scutum.require(['codemirror', 'codemirror-modes', 'codemirror-addons'], function () {
		scutum.plugins.codeEditor.instance();
		// fullscreen mode
		scutum.plugins.codeEditor.fullscreen();
		// read file
		scutum.plugins.codeEditor.files.read();
		// referesh cM
		scutum.plugins.codeEditor.refresh();
	}, false);
};
scutum.plugins.codeEditor.instance = function () {
	cmEditor = CodeMirror.fromTextArea($codeEditor[0], {
		lineNumbers: true,
		mode: 'text/html',
		matchTags: {
			bothTags: true
		},
		scrollbarStyle: "simple",
		extraKeys: {
			"F11": function (cm) {
				cm.setOption("fullScreen", !cm.getOption("fullScreen"));
			},
			"Esc": function (cm) {
				if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
			}
		}
	});
	// set content
	cmEditor.setValue(scutum.plugins.codeEditor.files.content['index.html']);
	// set dimmensions
	cmEditor.setSize("100%", "100%");
	// set theme
	cmEditor.setOption("theme", 'material');
};
scutum.plugins.codeEditor.fullscreen = function () {
	$codeEditor
		.next('.CodeMirror').append('<button class="uk-close" type="button" id="sc-code-editor-fs-disable" data-uk-close></button>')
		// disable fullscreen
		.on('click', '#sc-code-editor-fs-disable', function () {
			cmEditor.setOption("fullScreen", false);
			scutum.$body.removeClass('CodeMirror-fullscreen-active');
		});
	$('#sc-code-editor-fs-enable').on('click', function (e) {
		e.preventDefault();
		cmEditor.setOption("fullScreen", true);
		scutum.$body.addClass('CodeMirror-fullscreen-active');
	});
};
scutum.plugins.codeEditor.files = {};
scutum.plugins.codeEditor.files.read = function () {
	$('.sc-code-editor-files').on('click', '[data-file]', function (e) {
		e.preventDefault();
		var $this = $(this);
		$codeEditor.addClass('content-loading');
		scutum.helpers.preloader.overlayShow(false, '#cmEditor-col');
		// hide offcanvas
		if (scutum.helpers.mq.mediumMax()) {
			UIkit.offcanvas(scutum.$offcanvas).hide();
		}
		var file = $(this).attr('data-file');
		var mode = $(this).attr('data-mode');
		// set new content
		setTimeout(function () {
			if (mode === 'html') {
				cmEditor.setOption("mode", "text/html");
				cmEditor.setOption("matchTags", {
					bothTags: true
				});
			}
			if (mode === 'js') {
				cmEditor.setOption("mode", "text/javascript");
				cmEditor.setOption("matchBrackets", true);
			}
			if (mode === 'php') {
				cmEditor.setOption("mode", "application/x-httpd-php");
				cmEditor.setOption("matchTags", false);
				cmEditor.setOption("matchBrackets", true);
			}
			if (mode === 'json') {
				cmEditor.setOption("mode", "application/ld+json");
			}
			if (file !== '' && file in scutum.plugins.codeEditor.files.content) {
				cmEditor.setValue(scutum.plugins.codeEditor.files.content[file]);
			} else {
				cmEditor.setValue('File not exist!');
			}
			$this.closest('.sc-code-editor-files').find('.sc-list-group').removeClass('uk-active');
			$this.closest('.sc-list-group').addClass('uk-active');
			scutum.helpers.preloader.overlayHide();
		}, 500);
	})
};
scutum.plugins.codeEditor.files.content = {
	'index.html': "<!doctype html>\n" +
		"<html lang=\"en\">\n" +
		"<head>\n" +
		"<meta charset=\"UTF-8\">\n" +
		" <meta name=\"viewport\" content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">\n" +
		" <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">\n" +
		" <title>Document</title>\n" +
		"</head>\n" +
		"<body>\n" +
		"    <div class=\"uk-overflow-auto\">\n" +
		"        <table class=\"uk-table uk-table-hover\">\n" +
		"            <caption>Table caption</caption>\n" +
		"            <thead>\n" +
		"                <tr>\n" +
		"                    <th>Table Heading</th>\n" +
		"                    <th>Table Heading</th>\n" +
		"                    <th>Table Heading</th>\n" +
		"                    <th>Table Heading</th>\n" +
		"                </tr>\n" +
		"            </thead>\n" +
		"            <tfoot>\n" +
		"                <tr>\n" +
		"                    <td>Table Footer</td>\n" +
		"                    <td>Table Footer</td>\n" +
		"                    <td>Table Footer</td>\n" +
		"                    <td>Table Footer</td>\n" +
		"                </tr>\n" +
		"            </tfoot>\n" +
		"            <tbody>\n" +
		"                <tr>\n" +
		"                    <td>Table Data <a href=\"#\">a element</a> <code>.uk-table</code></td>\n" +
		"                    <td>Table Data <a class=\"uk-button uk-button-primary\" href=\"#\">Button</a></td>\n" +
		"                    <td>Table Data <img src=\"images/photo.jpg\" width=\"40\" alt=\"\"></td>\n" +
		"                    <td>Table Data</td>\n" +
		"                </tr>\n" +
		"                <tr>\n" +
		"                    <td>Table Data</td>\n" +
		"                    <td>Table Data</td>\n" +
		"                    <td>Table Data</td>\n" +
		"                    <td>Table Data</td>\n" +
		"                </tr>\n" +
		"                <tr class=\"uk-active\">\n" +
		"                    <td>Active Row</td>\n" +
		"                    <td>Active Row</td>\n" +
		"                    <td>Active Row</td>\n" +
		"                    <td>Active Row</td>\n" +
		"                </tr>\n" +
		"                <tr>\n" +
		"                    <td>Table Data</td>\n" +
		"                    <td>Table Data</td>\n" +
		"                    <td>Table Data</td>\n" +
		"                    <td>Table Data</td>\n" +
		"                </tr>\n" +
		"                <tr>\n" +
		"                    <th>Table Sub Heading</th>\n" +
		"                    <th>Table Sub Heading</th>\n" +
		"                    <th>Table Sub Heading</th>\n" +
		"                    <th>Table Sub Heading</th>\n" +
		"                </tr>\n" +
		"                <tr>\n" +
		"                    <td>Table Data</td>\n" +
		"                    <td>Table Data</td>\n" +
		"                    <td>Table Data</td>\n" +
		"                    <td>Table Data</td>\n" +
		"                </tr>\n" +
		"                <tr>\n" +
		"                    <td>Table Data</td>\n" +
		"                    <td>Table Data</td>\n" +
		"                    <td>Table Data</td>\n" +
		"                    <td>Table Data</td>\n" +
		"                </tr>\n" +
		"            </tbody>\n" +
		"        </table>\n" +
		"    </div>\n" +
		"</body>\n" +
		"</html>",
	'database.php': "<?php\n" +
		"return [\n" +
		"\n" +
		"    /*\n" +
		"    |--------------------------------------------------------------------------\n" +
		"    | Default Database Connection Name\n" +
		"    |--------------------------------------------------------------------------\n" +
		"    |\n" +
		"    | Here you may specify which of the database connections below you wish\n" +
		"    | to use as your default connection for all database work. Of course\n" +
		"    | you may use many connections at once using the Database library.\n" +
		"    |\n" +
		"    */\n" +
		"\n" +
		"    'default' => env('DB_CONNECTION', 'mysql'),\n" +
		"\n" +
		"    /*\n" +
		"    |--------------------------------------------------------------------------\n" +
		"    | Database Connections\n" +
		"    |--------------------------------------------------------------------------\n" +
		"    |\n" +
		"    | Here are each of the database connections setup for your application.\n" +
		"    | Of course, examples of configuring each database platform that is\n" +
		"    | supported by Laravel is shown below to make development simple.\n" +
		"    |\n" +
		"    |\n" +
		"    | All database work in Laravel is done through the PHP PDO facilities\n" +
		"    | so make sure you have the driver for your particular database of\n" +
		"    | choice installed on your machine before you begin development.\n" +
		"    |\n" +
		"    */\n" +
		"\n" +
		"    'connections' => [\n" +
		"\n" +
		"        'sqlite' => [\n" +
		"            'driver' => 'sqlite',\n" +
		"            'database' => env('DB_DATABASE', database_path('database.sqlite')),\n" +
		"            'prefix' => '',\n" +
		"            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),\n" +
		"        ],\n" +
		"\n" +
		"        'mysql' => [\n" +
		"            'driver' => 'mysql',\n" +
		"            'host' => env('DB_HOST', '127.0.0.1'),\n" +
		"            'port' => env('DB_PORT', '3306'),\n" +
		"            'database' => env('DB_DATABASE', 'forge'),\n" +
		"            'username' => env('DB_USERNAME', 'forge'),\n" +
		"            'password' => env('DB_PASSWORD', ''),\n" +
		"            'unix_socket' => env('DB_SOCKET', ''),\n" +
		"            'charset' => 'utf8mb4',\n" +
		"            'collation' => 'utf8mb4_unicode_ci',\n" +
		"            'prefix' => '',\n" +
		"            'prefix_indexes' => true,\n" +
		"            'strict' => true,\n" +
		"            'engine' => null,\n" +
		"        ],\n" +
		"\n" +
		"        'pgsql' => [\n" +
		"            'driver' => 'pgsql',\n" +
		"            'host' => env('DB_HOST', '127.0.0.1'),\n" +
		"            'port' => env('DB_PORT', '5432'),\n" +
		"            'database' => env('DB_DATABASE', 'forge'),\n" +
		"            'username' => env('DB_USERNAME', 'forge'),\n" +
		"            'password' => env('DB_PASSWORD', ''),\n" +
		"            'charset' => 'utf8',\n" +
		"            'prefix' => '',\n" +
		"            'prefix_indexes' => true,\n" +
		"            'schema' => 'public',\n" +
		"            'sslmode' => 'prefer',\n" +
		"        ],\n" +
		"\n" +
		"        'sqlsrv' => [\n" +
		"            'driver' => 'sqlsrv',\n" +
		"            'host' => env('DB_HOST', 'localhost'),\n" +
		"            'port' => env('DB_PORT', '1433'),\n" +
		"            'database' => env('DB_DATABASE', 'forge'),\n" +
		"            'username' => env('DB_USERNAME', 'forge'),\n" +
		"            'password' => env('DB_PASSWORD', ''),\n" +
		"            'charset' => 'utf8',\n" +
		"            'prefix' => '',\n" +
		"            'prefix_indexes' => true,\n" +
		"        ],\n" +
		"\n" +
		"    ],\n" +
		"\n" +
		"    /*\n" +
		"    |--------------------------------------------------------------------------\n" +
		"    | Migration Repository Table\n" +
		"    |--------------------------------------------------------------------------\n" +
		"    |\n" +
		"    | This table keeps track of all the migrations that have already run for\n" +
		"    | your application. Using this information, we can determine which of\n" +
		"    | the migrations on disk haven't actually been run in the database.\n" +
		"    |\n" +
		"    */\n" +
		"\n" +
		"    'migrations' => 'migrations',\n" +
		"\n" +
		"    /*\n" +
		"    |--------------------------------------------------------------------------\n" +
		"    | Redis Databases\n" +
		"    |--------------------------------------------------------------------------\n" +
		"    |\n" +
		"    | Redis is an open source, fast, and advanced key-value store that also\n" +
		"    | provides a richer set of commands than a typical key-value systems\n" +
		"    | such as APC or Memcached. Laravel makes it easy to dig right in.\n" +
		"    |\n" +
		"    */\n" +
		"\n" +
		"    'redis' => [\n" +
		"\n" +
		"        'client' => 'predis',\n" +
		"\n" +
		"        'default' => [\n" +
		"            'host' => env('REDIS_HOST', '127.0.0.1'),\n" +
		"            'password' => env('REDIS_PASSWORD', null),\n" +
		"            'port' => env('REDIS_PORT', 6379),\n" +
		"            'database' => env('REDIS_DB', 0),\n" +
		"        ],\n" +
		"\n" +
		"        'cache' => [\n" +
		"            'host' => env('REDIS_HOST', '127.0.0.1'),\n" +
		"            'password' => env('REDIS_PASSWORD', null),\n" +
		"            'port' => env('REDIS_PORT', 6379),\n" +
		"            'database' => env('REDIS_CACHE_DB', 1),\n" +
		"        ],\n" +
		"\n" +
		"    ],\n" +
		"\n" +
		"];\n" +
		"?>",
	"helpers.js": "/* @flow */\n" +
		"\n" +
		"import { emptyObject } from 'shared/util'\n" +
		"import { parseFilters } from './parser/filter-parser'\n" +
		"\n" +
		"export function baseWarn (msg: string) {\n" +
		"  console.error(`[Vue compiler]: ${msg}`)\n" +
		"}\n" +
		"\n" +
		"export function pluckModuleFunction<F: Function> (\n" +
		"  modules: ?Array<Object>,\n" +
		"  key: string\n" +
		"): Array<F> {\n" +
		"  return modules\n" +
		"    ? modules.map(m => m[key]).filter(_ => _)\n" +
		"    : []\n" +
		"}\n" +
		"\n" +
		"export function addProp (el: ASTElement, name: string, value: string) {\n" +
		"  (el.props || (el.props = [])).push({ name, value })\n" +
		"  el.plain = false\n" +
		"}\n" +
		"\n" +
		"export function addAttr (el: ASTElement, name: string, value: any) {\n" +
		"  (el.attrs || (el.attrs = [])).push({ name, value })\n" +
		"  el.plain = false\n" +
		"}\n" +
		"\n" +
		"// add a raw attr (use this in preTransforms)\n" +
		"export function addRawAttr (el: ASTElement, name: string, value: any) {\n" +
		"  el.attrsMap[name] = value\n" +
		"  el.attrsList.push({ name, value })\n" +
		"}\n" +
		"\n" +
		"export function addDirective (\n" +
		"  el: ASTElement,\n" +
		"  name: string,\n" +
		"  rawName: string,\n" +
		"  value: string,\n" +
		"  arg: ?string,\n" +
		"  modifiers: ?ASTModifiers\n" +
		") {\n" +
		"  (el.directives || (el.directives = [])).push({ name, rawName, value, arg, modifiers })\n" +
		"  el.plain = false\n" +
		"}\n" +
		"\n" +
		"export function addHandler (\n" +
		"  el: ASTElement,\n" +
		"  name: string,\n" +
		"  value: string,\n" +
		"  modifiers: ?ASTModifiers,\n" +
		"  important?: boolean,\n" +
		"  warn?: Function\n" +
		") {\n" +
		"  modifiers = modifiers || emptyObject\n" +
		"  // warn prevent and passive modifier\n" +
		"  /* istanbul ignore if */\n" +
		"  if (\n" +
		"    process.env.NODE_ENV !== 'production' && warn &&\n" +
		"    modifiers.prevent && modifiers.passive\n" +
		"  ) {\n" +
		"    warn(\n" +
		"      'passive and prevent can\\'t be used together. ' +\n" +
		"      'Passive handler can\\'t prevent default event.'\n" +
		"    )\n" +
		"  }\n" +
		"\n" +
		"  // normalize click.right and click.middle since they don't actually fire\n" +
		"  // this is technically browser-specific, but at least for now browsers are\n" +
		"  // the only target envs that have right/middle clicks.\n" +
		"  if (name === 'click') {\n" +
		"    if (modifiers.right) {\n" +
		"      name = 'contextmenu'\n" +
		"      delete modifiers.right\n" +
		"    } else if (modifiers.middle) {\n" +
		"      name = 'mouseup'\n" +
		"    }\n" +
		"  }\n" +
		"\n" +
		"  // check capture modifier\n" +
		"  if (modifiers.capture) {\n" +
		"    delete modifiers.capture\n" +
		"    name = '!' + name // mark the event as captured\n" +
		"  }\n" +
		"  if (modifiers.once) {\n" +
		"    delete modifiers.once\n" +
		"    name = '~' + name // mark the event as once\n" +
		"  }\n" +
		"  /* istanbul ignore if */\n" +
		"  if (modifiers.passive) {\n" +
		"    delete modifiers.passive\n" +
		"    name = '&' + name // mark the event as passive\n" +
		"  }\n" +
		"\n" +
		"  let events\n" +
		"  if (modifiers.native) {\n" +
		"    delete modifiers.native\n" +
		"    events = el.nativeEvents || (el.nativeEvents = {})\n" +
		"  } else {\n" +
		"    events = el.events || (el.events = {})\n" +
		"  }\n" +
		"\n" +
		"  const newHandler: any = {\n" +
		"    value: value.trim()\n" +
		"  }\n" +
		"  if (modifiers !== emptyObject) {\n" +
		"    newHandler.modifiers = modifiers\n" +
		"  }\n" +
		"\n" +
		"  const handlers = events[name]\n" +
		"  /* istanbul ignore if */\n" +
		"  if (Array.isArray(handlers)) {\n" +
		"    important ? handlers.unshift(newHandler) : handlers.push(newHandler)\n" +
		"  } else if (handlers) {\n" +
		"    events[name] = important ? [newHandler, handlers] : [handlers, newHandler]\n" +
		"  } else {\n" +
		"    events[name] = newHandler\n" +
		"  }\n" +
		"\n" +
		"  el.plain = false\n" +
		"}\n" +
		"\n" +
		"export function getBindingAttr (\n" +
		"  el: ASTElement,\n" +
		"  name: string,\n" +
		"  getStatic?: boolean\n" +
		"): ?string {\n" +
		"  const dynamicValue =\n" +
		"    getAndRemoveAttr(el, ':' + name) ||\n" +
		"    getAndRemoveAttr(el, 'v-bind:' + name)\n" +
		"  if (dynamicValue != null) {\n" +
		"    return parseFilters(dynamicValue)\n" +
		"  } else if (getStatic !== false) {\n" +
		"    const staticValue = getAndRemoveAttr(el, name)\n" +
		"    if (staticValue != null) {\n" +
		"      return JSON.stringify(staticValue)\n" +
		"    }\n" +
		"  }\n" +
		"}\n" +
		"\n" +
		"// note: this only removes the attr from the Array (attrsList) so that it\n" +
		"// doesn't get processed by processAttrs.\n" +
		"// By default it does NOT remove it from the map (attrsMap) because the map is\n" +
		"// needed during codegen.\n" +
		"export function getAndRemoveAttr (\n" +
		"  el: ASTElement,\n" +
		"  name: string,\n" +
		"  removeFromMap?: boolean\n" +
		"): ?string {\n" +
		"  let val\n" +
		"  if ((val = el.attrsMap[name]) != null) {\n" +
		"    const list = el.attrsList\n" +
		"    for (let i = 0, l = list.length; i < l; i++) {\n" +
		"      if (list[i].name === name) {\n" +
		"        list.splice(i, 1)\n" +
		"        break\n" +
		"      }\n" +
		"    }\n" +
		"  }\n" +
		"  if (removeFromMap) {\n" +
		"    delete el.attrsMap[name]\n" +
		"  }\n" +
		"  return val\n" +
		"}",
	"data.json": "[{\n" +
		"\t\t\"id\": 1,\n" +
		"\t\t\"first_name\": \"Adella\",\n" +
		"\t\t\"last_name\": \"Figura\",\n" +
		"\t\t\"email\": \"afigura0@opera.com\",\n" +
		"\t\t\"gender\": \"Female\",\n" +
		"\t\t\"ip_address\": \"205.130.124.144\"\n" +
		"\t}, {\n" +
		"\t\t\"id\": 2,\n" +
		"\t\t\"first_name\": \"Addie\",\n" +
		"\t\t\"last_name\": \"Vasse\",\n" +
		"\t\t\"email\": \"avasse1@answers.com\",\n" +
		"\t\t\"gender\": \"Female\",\n" +
		"\t\t\"ip_address\": \"76.226.233.169\"\n" +
		"\t}, {\n" +
		"\t\t\"id\": 3,\n" +
		"\t\t\"first_name\": \"Josee\",\n" +
		"\t\t\"last_name\": \"Birkett\",\n" +
		"\t\t\"email\": \"jbirkett2@mapy.cz\",\n" +
		"\t\t\"gender\": \"Female\",\n" +
		"\t\t\"ip_address\": \"235.147.89.150\"\n" +
		"\t}, {\n" +
		"\t\t\"id\": 4,\n" +
		"\t\t\"first_name\": \"Orville\",\n" +
		"\t\t\"last_name\": \"Hayler\",\n" +
		"\t\t\"email\": \"ohayler3@bloomberg.com\",\n" +
		"\t\t\"gender\": \"Male\",\n" +
		"\t\t\"ip_address\": \"32.233.217.40\"\n" +
		"\t}, {\n" +
		"\t\t\"id\": 5,\n" +
		"\t\t\"first_name\": \"Mandie\",\n" +
		"\t\t\"last_name\": \"McDavid\",\n" +
		"\t\t\"email\": \"mmcdavid4@homestead.com\",\n" +
		"\t\t\"gender\": \"Female\",\n" +
		"\t\t\"ip_address\": \"252.94.209.149\"\n" +
		"\t}, {\n" +
		"\t\t\"id\": 6,\n" +
		"\t\t\"first_name\": \"Jarrod\",\n" +
		"\t\t\"last_name\": \"Heis\",\n" +
		"\t\t\"email\": \"jheis5@joomla.org\",\n" +
		"\t\t\"gender\": \"Male\",\n" +
		"\t\t\"ip_address\": \"184.37.13.87\"\n" +
		"\t}, {\n" +
		"\t\t\"id\": 7,\n" +
		"\t\t\"first_name\": \"Abeu\",\n" +
		"\t\t\"last_name\": \"Staziker\",\n" +
		"\t\t\"email\": \"astaziker6@pen.io\",\n" +
		"\t\t\"gender\": \"Male\",\n" +
		"\t\t\"ip_address\": \"183.26.126.11\"\n" +
		"\t}, {\n" +
		"\t\t\"id\": 8,\n" +
		"\t\t\"first_name\": \"Jenifer\",\n" +
		"\t\t\"last_name\": \"Bengle\",\n" +
		"\t\t\"email\": \"jbengle7@marketwatch.com\",\n" +
		"\t\t\"gender\": \"Female\",\n" +
		"\t\t\"ip_address\": \"65.75.112.56\"\n" +
		"\t}, {\n" +
		"\t\t\"id\": 9,\n" +
		"\t\t\"first_name\": \"Gertrudis\",\n" +
		"\t\t\"last_name\": \"Ashcroft\",\n" +
		"\t\t\"email\": \"gashcroft8@amazon.de\",\n" +
		"\t\t\"gender\": \"Female\",\n" +
		"\t\t\"ip_address\": \"111.129.62.109\"\n" +
		"\t}, {\n" +
		"\t\t\"id\": 10,\n" +
		"\t\t\"first_name\": \"Emmie\",\n" +
		"\t\t\"last_name\": \"Paulazzi\",\n" +
		"\t\t\"email\": \"epaulazzi9@lulu.com\",\n" +
		"\t\t\"gender\": \"Female\",\n" +
		"\t\t\"ip_address\": \"219.228.186.196\"\n" +
		"\t}]"
};
scutum.plugins.codeEditor.refresh = function () {
	$('.sc-js-column').on('collapse expand', function() {
		cmEditor.refresh()
	});
};